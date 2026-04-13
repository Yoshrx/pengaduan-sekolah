@extends('layouts.app')

@section('content')
<h2 style="color:#1a3c5e; margin-bottom:20px;">Dashboard Admin</h2>

{{-- STATISTIK UTAMA --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $statistik['total'] }}</div>
        <div class="stat-label">Total Pengaduan</div>
    </div>
    <div class="stat-card menunggu">
        <div class="stat-number">{{ $statistik['menunggu'] }}</div>
        <div class="stat-label">Menunggu</div>
    </div>
    <div class="stat-card proses">
        <div class="stat-number">{{ $statistik['proses'] }}</div>
        <div class="stat-label">Sedang Diproses</div>
    </div>
    <div class="stat-card selesai">
        <div class="stat-number">{{ $statistik['selesai'] }}</div>
        <div class="stat-label">Selesai</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
    {{-- PENGADUAN TERBARU --}}
    <div class="card">
        <div class="card-title">5 Pengaduan Terbaru</div>
        <table>
            <thead>
                <tr>
                    <th>Siswa</th>
                    <th>Judul</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($terbaru as $p)
                <tr>
                    <td>{{ $p->user->name }}</td>
                    <td>
                        <a href="{{ route('admin.pengaduan.show', $p->id) }}" style="color:#2d6a9f; text-decoration:none;">
                            {{ Str::limit($p->judul, 30) }}
                        </a>
                    </td>
                    <td>
                        <span class="badge {{ $p->badge_status }}">{{ $p->status }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center; color:#999;">Belum ada pengaduan</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top:15px;">
            <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-primary btn-sm">Lihat Semua →</a>
        </div>
    </div>

    {{-- STATISTIK PER KATEGORI --}}
    <div class="card">
        <div class="card-title">Pengaduan per Kategori</div>
        @if(count($perKategori) > 0)
            @foreach($perKategori as $nama => $jumlah)
            @php $pct = $statistik['total'] > 0 ? round($jumlah/$statistik['total']*100) : 0; @endphp
            <div style="margin-bottom:14px;">
                <div style="display:flex; justify-content:space-between; font-size:0.88rem; margin-bottom:5px;">
                    <span>{{ $nama }}</span>
                    <strong>{{ $jumlah }}</strong>
                </div>
                <div class="progress-bar-wrap">
                    <div class="progress-bar-fill" style="width:{{ $pct }}%;"></div>
                </div>
            </div>
            @endforeach
        @else
            <p style="color:#999; text-align:center;">Belum ada data kategori</p>
        @endif
    </div>
</div>
@endsection
