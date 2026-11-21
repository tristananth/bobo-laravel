<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaDetail extends Model
{
    protected $table = 'nota_detail';
    public $timestamps = false;
    protected $guarded = [];

    public function layanan() { return $this->belongsTo(Layanan::class); }
}
