<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori'];

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }

    /**
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
