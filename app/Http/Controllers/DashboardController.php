<?php
namespace App\Http\Controllers;

use App\Models\{Hewan, Nota, NotaDetail, Pemilik};

class DashboardController extends Controller
{
    public function index()
    {
        $b = now();
        $bulan = Nota::whereYear('tanggal', $b->year)->whereMonth('tanggal', $b->month);
        $stat = ['count' => (clone $bulan)->count(), 'sum' => (clone $bulan)->sum('total'), 'pemilik' => Pemilik::count(), 'hewan' => Hewan::count()];
        $L = NotaDetail::join('nota', 'nota.id', '=', 'nota_detail.nota_id')
            ->join('layanan', 'layanan.id', '=', 'nota_detail.layanan_id')
            ->whereYear('nota.tanggal', $b->year)->whereMonth('nota.tanggal', $b->month)
            ->groupBy('layanan.id', 'layanan.nama')->orderByDesc('s')
            ->selectRaw('layanan.nama, COUNT(nota_detail.id) n, SUM(nota_detail.harga) s')->get();
        $max = max(1, (int)$L->max('s'));
        $R = Nota::with('pemilik', 'hewan')->orderByDesc('tanggal')->orderByDesc('id')->take(5)->get();
        return view('dashboard', compact('stat', 'L', 'max', 'R'));
    }
}
