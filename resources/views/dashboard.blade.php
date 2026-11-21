@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<h2>Halo, {{ auth()->user()->nama }}</h2>
<div class="cards">
<div class="c">Nota bulan ini<b>{{ $stat['count'] }}</b></div>
<div class="c">Pendapatan bulan ini<b>{{ \App\Support\Format::rp($stat['sum']) }}</b></div>
<div class="c">Total pemilik<b>{{ $stat['pemilik'] }}</b></div>
<div class="c">Total hewan<b>{{ $stat['hewan'] }}</b></div>
</div>
<h3>Pendapatan per layanan (bulan ini)</h3>
<div class="x"><table>
<tr><th>Layanan</th><th>Jumlah</th><th>Pendapatan</th><th style="width:30%"></th></tr>
@forelse($L as $r)
<tr><td>{{ $r->nama }}</td><td>{{ $r->n }}</td><td>{{ \App\Support\Format::rp($r->s) }}</td><td><div class="bar" style="width:{{ round($r->s / $max * 100) }}%"></div></td></tr>
@empty
<tr><td colspan="4">Belum ada data</td></tr>
@endforelse
</table></div>
<h3>Nota terakhir</h3>
<div class="x"><table>
<tr><th>No</th><th>Tanggal</th><th>Pemilik</th><th>Hewan</th><th>Total</th></tr>
@forelse($R as $r)
<tr><td><a href="{{ route('cetak.nota', $r) }}">{{ $r->no_nota }}</a></td><td>{{ \App\Support\Format::tgl($r->tanggal) }}</td><td>{{ $r->pemilik->nama }}</td><td>{{ $r->hewan->nama }}</td><td>{{ \App\Support\Format::rp($r->total) }}</td></tr>
@empty
<tr><td colspan="5">Belum ada nota</td></tr>
@endforelse
</table></div>
@endsection
