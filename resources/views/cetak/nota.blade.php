@extends('layouts.app')
@section('title', 'Cetak Nota')
@section('content')
@php
use App\Support\Format;
$cb = '';
foreach (['Anjing', 'Kucing', 'Kera', 'Unggas'] as $j) $cb .= ($nota->hewan->jenis_hewan === $j ? '☑' : '☐') . ' ' . $j . ' &nbsp; ';
$cb .= ($nota->hewan->jenis_hewan === 'Lainnya' ? '☑' : '☐') . ' Dll.';
$info = ['Tanggal' => e(Format::tgl($nota->tanggal)), 'Pemilik' => e($nota->pemilik->nama), 'Hewan' => $cb, 'Nama' => e($nota->hewan->nama), 'Jenis' => e($nota->hewan->ras), 'Alamat' => e($nota->pemilik->alamat)];
@endphp
<div class="np"><button onclick="window.print()">🖨 Cetak</button> <a class="btn y" href="{{ route('nota.index') }}">Kembali ke Nota</a></div>
<div class="n">
<h1>BOBO KLINIK &amp; PET SHOP</h1>
<div class="s">VAKSINASI, OPERASI, GROOMING, CHECK UP · TERIMA PANGGILAN<br>RUKO TRAFALGAR SRC/38 (DERETAN LOWSON) KOTA WISATA - CIBUBUR · TEL 021-22962747</div>
<hr>
<p><b>NOTA ADMINISTRASI</b> &nbsp; <b>NO.: {{ $nota->no_nota }}</b></p>
<table style="border:0">
@foreach($info as $k => $v)
<tr><td style="border:0;width:90px">{{ $k }}</td><td style="border:0">: {!! $v !!}</td></tr>
@endforeach
</table>
<h3 style="text-align:center">PERINCIAN / KET.</h3>
<table>
<tr><th>Layanan</th><th>Keterangan</th><th>Rp</th></tr>
@foreach($nota->details as $r)
<tr><td>{{ $r->layanan->nama }}</td><td>{{ $r->keterangan }}</td><td style="text-align:right">{{ number_format($r->harga, 0, ',', '.') }}</td></tr>
@endforeach
<tr><th colspan="2">Total</th><th style="text-align:right">Rp {{ number_format($nota->total, 0, ',', '.') }}</th></tr>
</table>
<p>Terbilang: <i>{{ Format::kata($nota->total) }}</i></p>
<p style="text-align:right">Cibubur, {{ Format::tgl($nota->tanggal) }}<br><b>Dokter Hewan,</b><br><br><br>{{ $nota->dokter->nama }}</p>
</div>
@endsection
