<?php
namespace App\Support;

use Illuminate\Support\Carbon;

class Format
{
    const MSG = [
        'required' => ':attribute wajib diisi',
        'max' => ':attribute terlalu panjang',
        'exists' => ':attribute tidak valid',
        'in' => ':attribute tidak valid',
        'date' => ':attribute bukan tanggal yang valid',
        'min' => ':attribute minimal :min item',
    ];

    public static function rp($n): string { return 'Rp ' . number_format((float)$n, 0, ',', '.'); }
    public static function tgl($d): string { return $d ? Carbon::parse($d)->format('d/m/Y') : ''; }

    public static function terbilang(int $x): string
    {
        $x = abs($x);
        $a = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
        if ($x < 12) return $a[$x];
        if ($x < 20) return self::terbilang($x - 10) . ' belas';
        if ($x < 100) return self::terbilang(intdiv($x, 10)) . ' puluh ' . self::terbilang($x % 10);
        if ($x < 200) return 'seratus ' . self::terbilang($x - 100);
        if ($x < 1000) return self::terbilang(intdiv($x, 100)) . ' ratus ' . self::terbilang($x % 100);
        if ($x < 2000) return 'seribu ' . self::terbilang($x - 1000);
        if ($x < 1000000) return self::terbilang(intdiv($x, 1000)) . ' ribu ' . self::terbilang($x % 1000);
        if ($x < 1000000000) return self::terbilang(intdiv($x, 1000000)) . ' juta ' . self::terbilang($x % 1000000);
        return self::terbilang(intdiv($x, 1000000000)) . ' miliar ' . self::terbilang($x % 1000000000);
    }

    public static function kata($n): string
    {
        $t = trim(preg_replace('/\s+/', ' ', self::terbilang((int)$n)));
        return ucfirst($t === '' ? 'nol' : $t) . ' rupiah';
    }
}
