<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>@yield('title') – BOBO Klinik</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@php
$tabs = [
  [route('dashboard'), 'Dashboard', 'dashboard'],
  [route('nota.index'), 'Nota', 'nota*'],
  [route('data.index', 'pemilik'), 'Pemilik', 'data/pemilik'],
  [route('data.index', 'hewan'), 'Hewan', 'data/hewan'],
  [route('data.index', 'layanan'), 'Layanan', 'data/layanan'],
  [route('data.index', 'dokter'), 'Dokter', 'data/dokter'],
  [route('cetak.laporan'), 'Cetak', 'cetak*'],
];
@endphp
<nav class="tabs np">
@foreach($tabs as [$u, $l, $p])
  <a class="t {{ request()->is($p) ? 'on' : '' }}" href="{{ $u }}">{{ $l }}</a>
@endforeach
<span style="flex:1"></span>
<a class="btn y" href="{{ route('home') }}">← Kembali ke Homepage</a>
<form method="post" action="{{ route('logout') }}" class="inl">@csrf<button class="r">Keluar</button></form>
</nav>
<main class="w">
@if(session('ok'))<div class="msg np">{{ session('ok') }}</div>@endif
@if($errors->any())<div class="msg np">@foreach($errors->all() as $e){{ $e }}<br>@endforeach</div>@endif
@yield('content')
</main>
</body>
</html>
