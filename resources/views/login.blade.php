<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login – BOBO Klinik</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<main class="w" style="max-width:380px;margin-top:60px">
<h2 style="color:#1f1a7a">Login Basis Data</h2>
@if($errors->any())<div class="msg">{{ $errors->first() }}</div>@endif
<form method="post" action="{{ route('login') }}">
@csrf
<div class="f" style="grid-template-columns:1fr">
<div><label>Username</label><input name="username" value="{{ old('username') }}" required autofocus></div>
<div><label>Password</label><input type="password" name="password" required></div>
</div>
<button>Masuk</button> <a class="btn y" href="{{ route('home') }}">← Kembali ke Homepage</a>
</form>
</main>
</body>
</html>
