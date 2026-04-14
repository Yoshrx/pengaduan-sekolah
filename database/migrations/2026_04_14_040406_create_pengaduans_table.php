<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    // Tabel kategori
    Schema::create('kategoris', function (Blueprint $table) {
        $table->id();
        $table->string('nama_kategori', 50);
        $table->timestamps();
    });

    Schema::create('pengaduans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->nullOnDelete();
        $table->string('judul');
        $table->text('isi_pengaduan');
        $table->string('lokasi', 100)->nullable();
        $table->enum('status', ['Menunggu', 'Proses', 'Selesai'])->default('Menunggu');
        $table->text('feedback')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
        Schema::dropIfExists('kategoris');
    }
};
