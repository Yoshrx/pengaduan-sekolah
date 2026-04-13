@extends('layouts.app')

@section('content')
<div style="margin-bottom:15px;">
    <a href="{{ route('siswa.pengaduan.index') }}" style="color:#2d6a9f; text-decoration:none;">← Kembali ke Riwayat</a>
</div>

<h2 style="color:#1a3c5e; margin-bottom:20px;">Detail Aspirasi</h2>

<div class="card">
    <div class="detail-row">
        <span class="detail-label">Tanggal Dikirim</span>
        <span class="detail-value">{{ $pengaduan->tanggal_format }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Kategori</span>
        <span class="detail-value">{{ $pengaduan->kategori->nama_kategori ?? '-' }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Judul</span>
        <span class="detail-value"><strong>{{ $pengaduan->judul }}</strong></span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Lokasi</span>
        <span class="detail-value">{{ $pengaduan->lokasi ?? '-' }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Status</span>
        <span class="detail-value">
            <span class="badge {{ $pengaduan->badge_status }}">{{ $pengaduan->status }}</span>
        </span>
    </div>
    <div style="margin-top:15px;">
        <div class="detail-label" style="margin-bottom:8px;">Isi Pengaduan</div>
        <div style="background:#f8f9fa; padding:15px; border-radius:8px; line-height:1.6;">
            {{ $pengaduan->isi_pengaduan }}
        </div>
    </div>

    @if($pengaduan->foto)
    <div style="margin-top:15px;">
        <div class="detail-label" style="margin-bottom:8px;">Foto Bukti</div>
        <img src="{{ asset('storage/' . $pengaduan->foto) }}"
             style="max-width:500px; border-radius:8px; border:1px solid #eee;">
    </div>
    @endif
</div>

{{-- PROGRES --}}
<div class="card">
    <div class="card-title">Progres Penanganan</div>
    @php
        $steps = ['Menunggu','Proses','Selesai'];
        $currentIdx = array_search($pengaduan->status, $steps);
    @endphp
    <div style="display:flex; margin-top:10px; position:relative; max-width:500px;">
        @foreach($steps as $i => $step)
        <div style="flex:1; text-align:center; position:relative;">
            <div style="
                width:40px; height:40px; border-radius:50%; margin:0 auto;
                display:flex; align-items:center; justify-content:center;
                font-weight:bold;
                background:{{ $i <= $currentIdx ? '#2d6a9f' : '#e9ecef' }};
                color:{{ $i <= $currentIdx ? 'white' : '#999' }};
                position:relative; z-index:1;
            ">{{ $i <= $currentIdx ? '✓' : ($i+1) }}</div>
            <div style="font-size:0.85rem; margin-top:8px; color:{{ $i <= $currentIdx ? '#1a3c5e' : '#999' }}; font-weight:{{ $i==$currentIdx?'bold':'normal' }};">
                {{ $step }}
            </div>
            @if($i < count($steps)-1)
            <div style="position:absolute; top:20px; left:50%; width:100%; height:3px; background:{{ $i < $currentIdx ? '#2d6a9f' : '#e9ecef' }}; z-index:0;"></div>
            @endif
        </div>
        @endforeach
    </div>
</div>

{{-- UMPAN BALIK --}}
<div class="card">
    <div class="card-title">Umpan Balik dari Admin</div>
    @if($pengaduan->feedback)
        <div class="feedback-box">
            <p style="line-height:1.7; color:#333;">{{ $pengaduan->feedback }}</p>
        </div>
    @else
        <div style="text-align:center; padding:20px; color:#999;">
            <p>Belum ada umpan balik dari admin. Pengaduan Anda sedang ditinjau.</p>
        </div>
    @endif
</div>
@endsection
