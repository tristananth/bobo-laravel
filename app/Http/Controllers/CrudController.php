<?php
namespace App\Http\Controllers;

use App\Models\{Dokter, Hewan, Layanan, Pemilik};
use App\Support\Format;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    private function cfg(string $t): array
    {
        $c = [
            'pemilik' => ['title' => 'Pemilik', 'model' => Pemilik::class,
                'fields' => ['nama' => ['Nama', 'text'], 'alamat' => ['Alamat', 'text'], 'telepon' => ['Telepon', 'text']],
                'rules' => ['nama' => 'required|max:100', 'alamat' => 'nullable|max:255', 'telepon' => 'nullable|max:30']],
            'hewan' => ['title' => 'Hewan', 'model' => Hewan::class,
                'fields' => ['pemilik_id' => ['Pemilik', 'fk'], 'nama' => ['Nama Hewan', 'text'], 'jenis_hewan' => ['Jenis Hewan', 'enum'], 'ras' => ['Jenis / Ras', 'text']],
                'rules' => ['pemilik_id' => 'required|exists:pemilik,id', 'nama' => 'required|max:100', 'jenis_hewan' => 'required|in:Anjing,Kucing,Kera,Unggas,Lainnya', 'ras' => 'nullable|max:100']],
            'layanan' => ['title' => 'Layanan', 'model' => Layanan::class,
                'fields' => ['nama' => ['Nama Layanan', 'text']], 'rules' => ['nama' => 'required|max:100']],
            'dokter' => ['title' => 'Dokter Hewan', 'model' => Dokter::class,
                'fields' => ['nama' => ['Nama Dokter', 'text']], 'rules' => ['nama' => 'required|max:100']],
        ];
        abort_unless(isset($c[$t]), 404);
        return $c[$t];
    }

    public function index(Request $r, string $t)
    {
        $cfg = $this->cfg($t);
        $m = $cfg['model'];
        $options = $t === 'hewan' ? [
            'pemilik_id' => Pemilik::orderBy('nama')->pluck('nama', 'id')->all(),
            'jenis_hewan' => array_combine($e = ['Anjing', 'Kucing', 'Kera', 'Unggas', 'Lainnya'], $e),
        ] : [];
        $edit = $r->query('edit') ? $m::find($r->query('edit')) : null;
        $rows = $m::orderByDesc('id')->get();
        return view('crud.index', compact('t', 'cfg', 'options', 'edit', 'rows'));
    }

    private function save(Request $r, string $t, $id = null)
    {
        $cfg = $this->cfg($t);
        $attr = collect($cfg['fields'])->map(fn($f) => $f[0])->all();
        $d = $r->validate($cfg['rules'], Format::MSG, $attr);
        try {
            $id ? $cfg['model']::findOrFail($id)->update($d) : $cfg['model']::create($d);
        } catch (QueryException $e) {
            return back()->withInput()->withErrors(['db' => 'Gagal: data sudah ada atau terkait data lain']);
        }
        return redirect()->route('data.index', $t)->with('ok', 'Data disimpan');
    }

    public function store(Request $r, string $t) { return $this->save($r, $t); }
    public function update(Request $r, string $t, int $id) { return $this->save($r, $t, $id); }

    public function destroy(string $t, int $id)
    {
        $cfg = $this->cfg($t);
        try {
            $cfg['model']::findOrFail($id)->delete();
        } catch (QueryException $e) {
            return back()->withErrors(['db' => 'Gagal: data masih dipakai di data lain']);
        }
        return back()->with('ok', 'Data dihapus');
    }
}
