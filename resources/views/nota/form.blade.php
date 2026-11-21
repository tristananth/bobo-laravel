@extends('layouts.app')
@section('title', 'Nota')
@section('content')
<h2>{{ $nota ? 'Ubah Nota ' . $nota->no_nota : 'Nota Baru' }}</h2>
<form method="post" action="{{ $nota ? route('nota.update', $nota) : route('nota.store') }}">
@csrf
@if($nota) @method('PUT') @endif
<div class="f">
<div><label>Tanggal</label><input type="date" name="tanggal" value="{{ old('tanggal', $nota?->tanggal?->format('Y-m-d') ?? date('Y-m-d')) }}" required></div>
<div><label>Pemilik</label><select name="pemilik_id" id="po"><option value="">Pilih pemilik</option>
@foreach($P as $k => $l)<option value="{{ $k }}" @selected(old('pemilik_id', $nota?->pemilik_id) == $k)>{{ $l }}</option>@endforeach
</select></div>
<div><label>Hewan</label><select name="hewan_id" id="he"></select></div>
<div><label>Dokter Hewan</label><select name="dokter_id"><option value="">Pilih dokter</option>
@foreach($D as $k => $l)<option value="{{ $k }}" @selected(old('dokter_id', $nota?->dokter_id) == $k)>{{ $l }}</option>@endforeach
</select></div>
</div>
<h3>Perincian</h3>
<div id="rows"></div>
<button type="button" class="btn y" onclick="add()">+ Tambah Rincian</button>
<p><b>Total: <span id="tot">Rp 0</span></b></p>
<button>Simpan Nota</button> <a class="btn y" href="{{ route('nota.index') }}">Batal</a>
</form>
<script>
const LAY=@json($LAY),HEW=@json($HEW),ROWS=@json($rows),CUR=@json(old('hewan_id', $nota?->hewan_id));
const $=s=>document.querySelector(s);
function hw(c){const p=$('#po').value,s=$('#he');s.innerHTML='';s.add(new Option('Pilih hewan',''));HEW.filter(h=>h.pemilik_id==p).forEach(h=>{const o=new Option(h.nama+' ('+h.jenis_hewan+')',h.id);if(h.id==c)o.selected=true;s.add(o)})}
function sum(){let t=0;document.querySelectorAll('[name="harga[]"]').forEach(i=>t+=parseInt(i.value.replace(/\D/g,''))||0);$('#tot').textContent='Rp '+t.toLocaleString('id-ID')}
function add(r){r=r||{};const d=document.createElement('div');d.className='f';
d.innerHTML='<select name="layanan_id[]"></select><input name="ket[]" placeholder="Keterangan"><input name="harga[]" inputmode="numeric" placeholder="Harga (Rp)"><button type="button" class="r">Hapus</button>';
const s=d.querySelector('select');s.add(new Option('Pilih layanan',''));LAY.forEach(l=>{const o=new Option(l.nama,l.id);if(l.id==r.layanan_id)o.selected=true;s.add(o)});
d.querySelector('[name="ket[]"]').value=r.keterangan||'';const h=d.querySelector('[name="harga[]"]');h.value=r.harga||'';h.oninput=sum;
d.querySelector('button').onclick=()=>{d.remove();sum()};$('#rows').append(d);sum()}
$('#po').onchange=()=>hw('');hw(CUR);(ROWS.length?ROWS:[{}]).forEach(add);
</script>
@endsection
