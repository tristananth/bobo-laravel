<?php
namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;

class CetakController extends Controller
{
    public function nota(Nota $nota)
    {
        $nota->load('pemilik', 'hewan', 'dokter', 'details.layanan');
        return view('cetak.nota', compact('nota'));
    }

    public function laporan(Request $r)
    {
        $d1 = $r->query('dari', date('Y-m-01'));
        $d2 = $r->query('sampai', date('Y-m-d'));
        $list = Nota::with('pemilik', 'hewan')->whereBetween('tanggal', [$d1, $d2])->orderBy('tanggal')->orderBy('id')->get();
        return view('cetak.laporan', compact('d1', 'd2', 'list'));
    }
}
