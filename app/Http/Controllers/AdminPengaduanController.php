<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPengaduanController extends Controller
{
    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $query = Pengaduan::with(['user', 'kategori'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('bulan')) {
            [$tahun, $bulan] = explode('-', $request->bulan);
            $query->whereMonth('created_at', (int)$bulan)
                  ->whereYear('created_at', (int)$tahun);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $pengaduans = $query->paginate(10)->withQueryString();

        $kategoris  = Kategori::orderBy('nama_kategori')->get();
        $siswas     = User::where('role', 'siswa')->orderBy('name')->get();

        return view('admin.pengaduan_index', compact('pengaduans', 'kategoris', 'siswas'));
    }

    /**
     * @param int $id
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::with(['user', 'kategori'])->findOrFail($id);
        return view('admin.detail_pengaduan', compact('pengaduan'));
    }

    /**
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
    
     /**
     * @param int $id
     */
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->foto) {
            \storage::disk('public')->delete($pengaduan->foto);
    }
    $pengaduan->delete();

    return redirect()
        ->route('admin.pengaduan.index')
        ->with('success','Pengaduan berhasil dihapus.');
    }
}
