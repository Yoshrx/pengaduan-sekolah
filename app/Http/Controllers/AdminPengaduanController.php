<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * AdminPengaduanController
 * Mengatur manajemen pengaduan dari sisi admin:
 * - index        : Daftar semua pengaduan (filter per tanggal, bulan, siswa, kategori)
 * - updateStatus : Ubah status dan tambahkan feedback pengaduan
 */
class AdminPengaduanController extends Controller
{
    /**
     * Menampilkan daftar pengaduan dengan filter lengkap
     * Filter yang tersedia: tanggal, bulan, siswa (user_id), kategori, status, cari judul
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        // Gunakan eager loading untuk efisiensi query (N+1 problem avoided)
        $query = Pengaduan::with(['user', 'kategori'])->latest();

        // --- Filter per Status ---
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // --- Filter per Kategori ---
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // --- Filter per Siswa ---
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // --- Filter per Tanggal ---
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // --- Filter per Bulan & Tahun ---
        if ($request->filled('bulan')) {
            [$tahun, $bulan] = explode('-', $request->bulan);
            $query->whereMonth('created_at', (int)$bulan)
                  ->whereYear('created_at', (int)$tahun);
        }

        // --- Pencarian per Judul ---
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $pengaduans = $query->paginate(10)->withQueryString();

        // Data untuk dropdown filter
        $kategoris  = Kategori::orderBy('nama_kategori')->get();
        $siswas     = User::where('role', 'siswa')->orderBy('name')->get();

        return view('admin.pengaduan_index', compact('pengaduans', 'kategoris', 'siswas'));
    }

    /**
     * Menampilkan form detail pengaduan untuk diberi feedback dan update status
     *
     * @param int $id
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::with(['user', 'kategori'])->findOrFail($id);
        return view('admin.detail_pengaduan', compact('pengaduan'));
    }

    /**
     * Mengubah status penyelesaian dan memberikan umpan balik (feedback) ke siswa
     * Prosedur:
     * 1. Validasi input status dan feedback
     * 2. Update record di database
     * 3. Redirect kembali dengan notifikasi sukses
     *
     * @param Request $request
     * @param int     $id
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'   => 'required|in:Menunggu,Proses,Selesai',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        $pengaduan->update([
            'status'   => $request->status,
            'feedback' => $request->feedback,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status dan umpan balik berhasil disimpan.');
    }
}
