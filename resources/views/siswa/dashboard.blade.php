@extends('layouts.app')

@section('content')
@php
    $user = auth()->user();
    $pengaduans = \App\Models\Pengaduan::where('user_id', $user->id)->get();
    $counts = [
        'total'    => $pengaduans->count(),
        'menunggu' => $pengaduans->where('status','Menunggu')->count(),
        'proses'   => $pengaduans->where('status','Proses')->count(),
        'selesai'  => $pengaduans->where('status','Selesai')->count(),
    ];
@endphp

<h2 style="color:#1a3c5e; margin-bottom:5px;">Halo, {{ $user->name }}!</h2>
<p style="color:#666; margin-bottom:20px;">
    NIS: <strong>{{ $user->nis ?? '-' }}</strong> &nbsp;|&nbsp;
    Kelas: <strong>{{ $user->kelas ?? '-' }}</strong>
</p>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $counts['total'] }}</div>
        <div class="stat-label">Total Pengaduan Saya</div>
    </div>
    <div class="stat-card menunggu">
        <div class="stat-number">{{ $counts['menunggu'] }}</div>
        <div class="stat-label">Menunggu</div>
    </div>
    <div class="stat-card proses">
        <div class="stat-number">{{ $counts['proses'] }}</div>
        <div class="stat-label">Diproses</div>
    </div>
    <div class="stat-card selesai">
        <div class="stat-number">{{ $counts['selesai'] }}</div>
        <div class="stat-label">Selesai</div>
    </div>
</div>

<div class="card" style="text-align:center; padding:30px;">
    <p style="font-size:1.1rem; color:#555; margin-bottom:20px;">
        Sampaikan keluhan atau masukan terkait sarana dan prasarana sekolah
    </p>
    <a href="{{ route('siswa.pengaduan.create') }}" class="btn btn-primary" style="font-size:1rem; padding:12px 30px;">
        Buat Pengaduan Baru
    </a>
    &nbsp;&nbsp;
    <a href="{{ route('siswa.pengaduan.index') }}" class="btn" style="background:#6c757d; color:white; font-size:1rem; padding:12px 30px;">
        Lihat Riwayat Aspirasi
    </a>
</div>
@endsection
