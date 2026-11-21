@extends('layouts.app')
@section('title', $cfg['title'])
@section('content')
<h2>{{ $cfg['title'] }}</h2>
<form method="post" action="{{ $edit ? route('data.update', [$t, $edit->id]) : route('data.store', $t) }}">
@csrf
@if($edit) @method('PUT') @endif
<div class="f">
@foreach($cfg['fields'] as $c => $d)
<div><label>{{ $d[0] }}</label>
@if(isset($options[$c]))
<select name="{{ $c }}"><option value="">Pilih</option>
@foreach($options[$c] as $k => $l)<option value="{{ $k }}" @selected((string)old($c, $edit?->{$c} ?? '') === (string)$k)>{{ $l }}</option>@endforeach
</select>
@else
<input name="{{ $c }}" value="{{ old($c, $edit?->{$c} ?? '') }}">
@endif
</div>
@endforeach
</div>
<button>Simpan</button>
@if($edit)<a class="btn y" href="{{ route('data.index', $t) }}">Batal</a>@endif
</form>
<div class="x"><table>
<tr>@foreach($cfg['fields'] as $d)<th>{{ $d[0] }}</th>@endforeach<th>Aksi</th></tr>
@forelse($rows as $r)
<tr>
@foreach($cfg['fields'] as $c => $d)
<td>{{ isset($options[$c]) ? ($options[$c][$r->{$c}] ?? '') : $r->{$c} }}</td>
@endforeach
<td>
<a class="btn y" href="{{ route('data.index', $t) }}?edit={{ $r->id }}">Ubah</a>
<form method="post" action="{{ route('data.destroy', [$t, $r->id]) }}" class="inl" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="r">Hapus</button></form>
</td>
</tr>
@empty
<tr><td colspan="{{ count($cfg['fields']) + 1 }}">Belum ada data</td></tr>
@endforelse
</table></div>
@endsection
