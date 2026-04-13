<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Mengisi tabel kategoris dengan data awal
     * Kategori sarana yang bisa diadukan oleh siswa
     */
    public function run(): void
    {
        // Gunakan array untuk efisiensi bulk insert
        $kategoris = [
            ['nama_kategori' => 'Kebersihan'],
            ['nama_kategori' => 'Fasilitas Kelas'],
            ['nama_kategori' => 'Toilet'],
            ['nama_kategori' => 'Lapangan & Olahraga'],
            ['nama_kategori' => 'Kantin'],
            ['nama_kategori' => 'Perpustakaan'],
            ['nama_kategori' => 'Laboratorium'],
            ['nama_kategori' => 'Lainnya'],
        ];

        foreach ($kategoris as $kat) {
            Kategori::create($kat);
        }
    }
}
