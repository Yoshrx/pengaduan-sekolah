<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Pengaduan
 * Menyimpan data aspirasi/pengaduan yang dikirimkan oleh siswa
 *
 * Kolom utama:
 * - user_id        : FK ke tabel users (siswa yang mengadu)
 * - kategori_id    : FK ke tabel kategoris
 * - judul          : Judul singkat pengaduan
 * - isi_pengaduan  : Detail isi pengaduan
 * - lokasi         : Lokasi sarana yang diadukan
 * - status         : Menunggu | Proses | Selesai
 * - feedback       : Umpan balik dari admin
 * - foto           : Path foto bukti (opsional)
 */
class Pengaduan extends Model
{
    use HasFactory;

    // Status yang valid sesuai soal UKK
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

    /**
     * Relasi: pengaduan dimiliki oleh satu user (siswa)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: pengaduan masuk ke satu kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Scope: filter berdasarkan status
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: filter berdasarkan kategori
     */
    public function scopeByKategori($query, int $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }

    /**
     * Scope: filter berdasarkan bulan dan tahun
     */
    public function scopeByBulan($query, int $bulan, int $tahun)
    {
        return $query->whereMonth('created_at', $bulan)
                     ->whereYear('created_at', $tahun);
    }

    /**
     * Mendapatkan badge warna status untuk tampilan UI
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
     * Format tanggal pengaduan ke bahasa Indonesia
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
     * Mendapatkan array statistik status (digunakan di dashboard admin)
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
