@extends('layouts.app')
@section('title', 'Laporan')
@section('content')
@php use App\Support\Format; @endphp
<h2>Laporan Nota</h2>
<form class="np" method="get" action="{{ route('cetak.laporan') }}">
<div class="f"><div><label>Dari</label><input type="date" name="dari" value="{{ $d1 }}"></div><div><label>Sampai</label><input type="date" name="sampai" value="{{ $d2 }}"></div></div>
<button>Tampilkan</button> <button type="button" onclick="window.print()">🖨 Cetak Laporan</button>
</form>
<p>Periode: {{ Format::tgl($d1) }} – {{ Format::tgl($d2) }}</p>
<div class="x"><table>
<tr><th>No</th><th>Tanggal</th><th>Pemilik</th><th>Hewan</th><th>Total</th></tr>
@foreach($list as $r)
<tr><td>{{ $r->no_nota }}</td><td>{{ Format::tgl($r->tanggal) }}</td><td>{{ $r->pemilik->nama }}</td><td>{{ $r->hewan->nama }}</td><td style="text-align:right">{{ Format::rp($r->total) }}</td></tr>
@endforeach
<tr><th colspan="4">Total ({{ $list->count() }} nota)</th><th style="text-align:right">{{ Format::rp($list->sum('total')) }}</th></tr>
</table></div>
@endsection
