@extends('layouts.app')
@section('title', 'Nota')
@section('content')
<h2>Nota Administrasi</h2>
<a class="btn" href="{{ route('nota.create') }}">+ Nota Baru</a>
<div class="x"><table>
<tr><th>No</th><th>Tanggal</th><th>Pemilik</th><th>Hewan</th><th>Total</th><th>Aksi</th></tr>
@forelse($list as $r)
<tr>
<td>{{ $r->no_nota }}</td><td>{{ \App\Support\Format::tgl($r->tanggal) }}</td><td>{{ $r->pemilik->nama }}</td><td>{{ $r->hewan->nama }}</td><td>{{ \App\Support\Format::rp($r->total) }}</td>
<td>
<a class="btn y" href="{{ route('nota.edit', $r) }}">Ubah</a>
<a class="btn" href="{{ route('cetak.nota', $r) }}">Cetak</a>
<form method="post" action="{{ route('nota.destroy', $r) }}" class="inl" onsubmit="return confirm('Hapus nota ini?')">@csrf @method('DELETE')<button class="r">Hapus</button></form>
</td>
</tr>
@empty
<tr><td colspan="6">Belum ada nota</td></tr>
@endforelse
</table></div>
@endsection
