<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::with('kategori')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('siswa.pengaduan_index', compact('pengaduans'));
    }

    public function create()
    {
        // Ambil semua kategori untuk dropdown
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('siswa.create_pengaduan', compact('kategoris'));
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'         => 'required|string|max:255',
            'isi_pengaduan' => 'required|string',
            'kategori_id'   => 'required|exists:kategoris,id',
            'lokasi'        => 'nullable|string|max:100',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan_foto', 'public');
        }

        Pengaduan::create([
            'user_id'       => Auth::id(),
            'kategori_id'   => $request->kategori_id,
            'judul'         => $request->judul,
            'isi_pengaduan' => $request->isi_pengaduan,
            'lokasi'        => $request->lokasi,
            'foto'          => $fotoPath,
            'status'        => Pengaduan::STATUS_MENUNGGU,
        ]);

        return redirect()
            ->route('siswa.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dikirim! Menunggu tindak lanjut admin.');
    }

    /**
     * @param int $id
     */
    public function show($id)
    {
        // Pastikan siswa hanya bisa lihat pengaduannya sendiri
        $pengaduan = Pengaduan::with('kategori')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('siswa.detail_pengaduan', compact('pengaduan'));
    }
}
