<?php
namespace App\Http\Controllers;

use App\Models\{Dokter, Hewan, Layanan, Nota, Pemilik};
use App\Support\Format;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB};
use Illuminate\Validation\ValidationException;

class NotaController extends Controller
{
    public function index()
    {
        $list = Nota::with('pemilik', 'hewan')->orderByDesc('tanggal')->orderByDesc('id')->get();
        return view('nota.index', compact('list'));
    }

    public function create() { return $this->form(null); }
    public function edit(Nota $nota) { return $this->form($nota); }

    private function form(?Nota $nota)
    {
        $rows = old('layanan_id')
            ? collect(old('layanan_id'))->map(fn($l, $i) => ['layanan_id' => $l, 'keterangan' => old("ket.$i", ''), 'harga' => old("harga.$i", '')])->values()
            : ($nota ? $nota->details->map(fn($d) => $d->only(['layanan_id', 'keterangan', 'harga']))->values() : collect());
        return view('nota.form', [
            'nota' => $nota, 'rows' => $rows,
            'P' => Pemilik::orderBy('nama')->pluck('nama', 'id'),
            'D' => Dokter::orderBy('nama')->pluck('nama', 'id'),
            'LAY' => Layanan::orderBy('id')->get(['id', 'nama']),
            'HEW' => Hewan::orderBy('nama')->get(['id', 'pemilik_id', 'nama', 'jenis_hewan']),
        ]);
    }

    private function save(Request $r, ?Nota $nota)
    {
        $d = $r->validate([
            'tanggal' => 'required|date', 'pemilik_id' => 'required|exists:pemilik,id',
            'hewan_id' => 'required|exists:hewan,id', 'dokter_id' => 'required|exists:dokter,id',
            'layanan_id' => 'required|array|min:1', 'layanan_id.*' => 'nullable|exists:layanan,id',
            'ket.*' => 'nullable|string|max:200', 'harga.*' => 'nullable|string|max:20',
        ], Format::MSG, ['tanggal' => 'Tanggal', 'pemilik_id' => 'Pemilik', 'hewan_id' => 'Hewan', 'dokter_id' => 'Dokter', 'layanan_id' => 'Rincian']);

        $rows = []; $tot = 0;
        foreach ($d['layanan_id'] as $i => $l) {
            if (!$l) continue;
            $h = (int)preg_replace('/\D/', '', (string)$r->input("harga.$i", '0'));
            $rows[] = ['layanan_id' => $l, 'keterangan' => trim((string)$r->input("ket.$i", '')), 'harga' => $h];
            $tot += $h;
        }
        if (!$rows) throw ValidationException::withMessages(['layanan_id' => 'Minimal satu rincian layanan']);
        if (!Hewan::where('id', $d['hewan_id'])->where('pemilik_id', $d['pemilik_id'])->exists())
            throw ValidationException::withMessages(['hewan_id' => 'Hewan tidak sesuai dengan pemilik']);

        DB::transaction(function () use ($d, $rows, $tot, &$nota) {
            $a = ['tanggal' => $d['tanggal'], 'pemilik_id' => $d['pemilik_id'], 'hewan_id' => $d['hewan_id'], 'dokter_id' => $d['dokter_id'], 'total' => $tot];
            if ($nota) {
                $nota->update($a);
                $nota->details()->delete();
            } else {
                $nota = Nota::create($a + ['no_nota' => uniqid('T'), 'user_id' => Auth::id()]);
                $nota->update(['no_nota' => sprintf('BK-%s-%05d', date('Y', strtotime($d['tanggal'])), $nota->id)]);
            }
            $nota->details()->createMany($rows);
        });
        return redirect()->route('nota.index')->with('ok', 'Nota disimpan');
    }

    public function store(Request $r) { return $this->save($r, null); }
    public function update(Request $r, Nota $nota) { return $this->save($r, $nota); }

    public function destroy(Nota $nota)
    {
        $nota->delete();
        return redirect()->route('nota.index')->with('ok', 'Nota dihapus');
    }
}
