<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\User;

/**
 * AdminDashboardController
 * Menampilkan ringkasan statistik pengaduan di halaman dashboard admin
 */
class AdminDashboardController extends Controller
{
    /**
     * Menghitung statistik pengaduan menggunakan fungsi getStatistikStatus() dari model
     * serta statistik per kategori
     */
    public function index()
    {
        // Gunakan fungsi statis dari model (reusable)
        $statistik = Pengaduan::getStatistikStatus();

        // Statistik per kategori menggunakan fungsi dari model Kategori
        $perKategori = Kategori::getStatistikPerKategori();

        // 5 pengaduan terbaru untuk ditampilkan di dashboard
        $terbaru = Pengaduan::with(['user', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('statistik', 'perKategori', 'terbaru'));
    }
}
