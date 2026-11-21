<?php
namespace Database\Seeders;

use App\Models\{Dokter, Hewan, Layanan, Nota, Pemilik, User};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['username' => 'admin', 'password' => 'admin123', 'nama' => 'Administrator']);
        foreach (['Konsultasi', 'Vaksinasi', 'Operasi', 'Obat-obatan', 'Foto X Ray', 'Collar', 'House Call', 'Lain-lain'] as $n)
            Layanan::create(['nama' => $n]);

        // Data contoh (fiktif)
        $o = Pemilik::create(['nama' => 'Tristan', 'alamat' => 'Tangerang', 'telepon' => '081234567890']);
        $h = Hewan::create(['pemilik_id' => $o->id, 'nama' => 'Golden', 'jenis_hewan' => 'Anjing', 'ras' => 'Golden Retriever']);
        $d = Dokter::create(['nama' => 'Dr. Anthony']);
        $n = Nota::create(['no_nota' => 'BK-' . date('Y') . '-00001', 'tanggal' => now()->toDateString(),
            'pemilik_id' => $o->id, 'hewan_id' => $h->id, 'dokter_id' => $d->id, 'total' => 150000, 'user_id' => 1]);
        $n->details()->createMany([
            ['layanan_id' => 1, 'keterangan' => 'Sakit', 'harga' => 100000],
            ['layanan_id' => 4, 'keterangan' => 'Obat Flu', 'harga' => 50000],
        ]);
    }
}
