<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dokter', function (Blueprint $t) {
            $t->id();
            $t->string('nama', 100);
        });
        Schema::create('pemilik', function (Blueprint $t) {
            $t->id();
            $t->string('nama', 100);
            $t->string('alamat')->nullable();
            $t->string('telepon', 30)->nullable();
        });
        Schema::create('hewan', function (Blueprint $t) {
            $t->id();
            $t->foreignId('pemilik_id')->constrained('pemilik')->restrictOnDelete();
            $t->string('nama', 100);
            $t->enum('jenis_hewan', ['Anjing', 'Kucing', 'Kera', 'Unggas', 'Lainnya']);
            $t->string('ras', 100)->nullable();
        });
        Schema::create('layanan', function (Blueprint $t) {
            $t->id();
            $t->string('nama', 100)->unique();
        });
        Schema::create('nota', function (Blueprint $t) {
            $t->id();
            $t->string('no_nota', 30)->unique();
            $t->date('tanggal');
            $t->foreignId('pemilik_id')->constrained('pemilik')->restrictOnDelete();
            $t->foreignId('hewan_id')->constrained('hewan')->restrictOnDelete();
            $t->foreignId('dokter_id')->constrained('dokter')->restrictOnDelete();
            $t->unsignedBigInteger('total')->default(0);
            $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
        });
        Schema::create('nota_detail', function (Blueprint $t) {
            $t->id();
            $t->foreignId('nota_id')->constrained('nota')->cascadeOnDelete();
            $t->foreignId('layanan_id')->constrained('layanan')->restrictOnDelete();
            $t->string('keterangan', 200)->nullable();
            $t->unsignedInteger('harga')->default(0);
        });
    }
    public function down(): void
    {
        foreach (['nota_detail', 'nota', 'layanan', 'hewan', 'pemilik', 'dokter'] as $t) Schema::dropIfExists($t);
    }
};
