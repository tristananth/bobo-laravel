<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hewan extends Model
{
    protected $table = 'hewan';
    public $timestamps = false;
    protected $guarded = [];

    public function pemilik() { return $this->belongsTo(Pemilik::class); }
}
