@extends('layouts.app')

@section('content')
<h2 style="color:#1a3c5e; margin-bottom:20px;">Data Pengaduan Siswa</h2>

@if(session('success'))
    <div class="alert alert-success"> {{ session('success') }}</div>
@endif

{{-- FILTER BAR --}}
<form method="GET" class="filter-bar">
    <div class="form-group">
        <label>Cari Judul</label>
        <input type="text" name="search" class="form-control" placeholder="Kata kunci..." value="{{ request('search') }}">
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="">Semua Status</option>
            @foreach(['Menunggu','Proses','Selesai'] as $s)
                <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Kategori</label>
        <select name="kategori_id" class="form-control">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}" {{ request('kategori_id')==$kat->id?'selected':'' }}>{{ $kat->nama_kategori }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Siswa</label>
        <select name="user_id" class="form-control">
            <option value="">Semua Siswa</option>
            @foreach($siswas as $s)
                <option value="{{ $s->id }}" {{ request('user_id')==$s->id?'selected':'' }}>{{ $s->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
    </div>
    <div style="display:flex; gap:8px; align-items:flex-end;">
        <button type="submit" class="btn btn-primary"> Filter</button>
        <a href="{{ route('admin.pengaduan.index') }}" class="btn" style="background:#6c757d; color:white;">Reset</a>
    </div>
</form>

{{-- TABEL --}}
<div class="card">
    <p style="font-size:0.85rem; color:#666; margin-bottom:15px;">
        Menampilkan {{ $pengaduans->total() }} pengaduan
    </p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengaduans as $p)
            <tr>
                <td>{{ $pengaduans->firstItem() + $loop->index }}</td>
                <td style="white-space:nowrap;">{{ $p->tanggal_format }}</td>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->user->kelas ?? '-' }}</td>
                <td>{{ Str::limit($p->judul, 40) }}</td>
                <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                <td><span class="badge {{ $p->badge_status }}">{{ $p->status }}</span></td>
                <td>
                    <a href="{{ route('admin.pengaduan.show', $p->id) }}" class="btn btn-primary btn-sm">Detail & Feedback</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; color:#999; padding:30px;">Tidak ada data pengaduan.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrapper">
        {{ $pengaduans->links() }}
    </div>
</div>
@endsection
