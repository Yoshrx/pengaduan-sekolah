<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Kategori
 * Menyimpan kategori sarana yang dapat diadukan (contoh: Kebersihan, Fasilitas, dll.)
 */
class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori'];

    /**
     * Relasi: satu kategori memiliki banyak pengaduan
     */
    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }

    /**
     * Menghitung jumlah pengaduan per kategori (digunakan di dashboard)
     * @return array
     */
    public static function getStatistikPerKategori(): array
    {
        $data = [];
        $kategoris = self::withCount('pengaduans')->get();
        foreach ($kategoris as $kat) {
            $data[$kat->nama_kategori] = $kat->pengaduans_count;
        }
        return $data;
    }
}
