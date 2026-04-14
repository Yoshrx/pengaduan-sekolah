<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\User;

class AdminDashboardController extends Controller
{

    public function index()
    {
        $statistik = Pengaduan::getStatistikStatus();

        $perKategori = Kategori::getStatistikPerKategori();

        $terbaru = Pengaduan::with(['user', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('statistik', 'perKategori', 'terbaru'));
    }
}
