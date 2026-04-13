@extends('layouts.app')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 style="color:#1a3c5e;">Riwayat Aspirasi Saya</h2>
    <a href="{{ route('siswa.pengaduan.create') }}" class="btn btn-primary">+ Buat Pengaduan Baru</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    @if($pengaduans->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Feedback</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduans as $index => $p)
            <tr>
                <td>{{ $pengaduans->firstItem() + $index }}</td>
                <td style="white-space:nowrap;">{{ $p->tanggal_format }}</td>
                <td>{{ Str::limit($p->judul, 40) }}</td>
                <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                <td><span class="badge {{ $p->badge_status }}">{{ $p->status }}</span></td>
                <td>
                    @if($p->feedback)
                        <span style="color:#28a745; font-size:0.85rem;">Ada umpan balik</span>
                    @else
                        <span style="color:#999; font-size:0.85rem;">-</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('siswa.pengaduan.show', $p->id) }}" class="btn btn-primary btn-sm">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrapper">
        {{ $pengaduans->links() }}
    </div>
    @else
    <div style="text-align:center; padding:40px; color:#999;">
        <div style="font-size:3rem; margin-bottom:15px;"></div>
        <p>Belum ada pengaduan yang dikirim.</p>
        <a href="{{ route('siswa.pengaduan.create') }}" class="btn btn-primary" style="margin-top:15px;">Buat Pengaduan Pertama</a>
    </div>
    @endif
</div>
@endsection
