<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'nota';
    public $timestamps = false;
    protected $guarded = [];

    protected $casts = ['tanggal' => 'date'];
    public function pemilik() { return $this->belongsTo(Pemilik::class); }
    public function hewan() { return $this->belongsTo(Hewan::class); }
    public function dokter() { return $this->belongsTo(Dokter::class); }
    public function details() { return $this->hasMany(NotaDetail::class); }
}
