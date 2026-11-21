<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    protected $table = 'pemilik';
    public $timestamps = false;
    protected $guarded = [];

    public function hewan() { return $this->hasMany(Hewan::class); }
}
