<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    const STATUS_MENUNGGU = 'Menunggu';
    const STATUS_PROSES   = 'Proses';
    const STATUS_SELESAI  = 'Selesai';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'isi_pengaduan',
        'lokasi',
        'foto',
        'status',
        'feedback',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByKategori($query, int $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }

    /**
     * @return string (class CSS)
     */
    public function getBadgeStatusAttribute(): string
    {
        $badges = [
            self::STATUS_MENUNGGU => 'badge-warning',
            self::STATUS_PROSES   => 'badge-info',
            self::STATUS_SELESAI  => 'badge-success',
        ];
        return $badges[$this->status] ?? 'badge-secondary';
    }

    /**
     * @return string
     */
    public function getTanggalFormatAttribute(): string
    {
        $bulan = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
        ];
        $dt = $this->created_at;
        return $dt->day . ' ' . $bulan[$dt->month] . ' ' . $dt->year;
    }

    /**
     * @return array
     */
    public static function getStatistikStatus(): array
    {
        return [
            'total'     => self::count(),
            'menunggu'  => self::where('status', self::STATUS_MENUNGGU)->count(),
            'proses'    => self::where('status', self::STATUS_PROSES)->count(),
            'selesai'   => self::where('status', self::STATUS_SELESAI)->count(),
        ];
    }
}
