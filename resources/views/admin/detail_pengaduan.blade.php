@extends('layouts.app')

@section('content')
<div style="margin-bottom:15px;">
    <a href="{{ route('admin.pengaduan.index') }}" style="color:#2d6a9f; text-decoration:none;">← Kembali ke Daftar</a>
</div>

<h2 style="color:#1a3c5e; margin-bottom:20px;">Detail Pengaduan</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
    {{-- INFO PENGADUAN --}}
    <div class="card">
        <div class="card-title">Informasi Pengaduan</div>

        <div class="detail-row">
            <span class="detail-label">Tanggal</span>
            <span class="detail-value">{{ $pengaduan->tanggal_format }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Nama Siswa</span>
            <span class="detail-value">{{ $pengaduan->user->name }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">NIS</span>
            <span class="detail-value">{{ $pengaduan->user->nis ?? '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Kelas</span>
            <span class="detail-value">{{ $pengaduan->user->kelas ?? '-' }}</span>
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
                 style="max-width:100%; border-radius:8px; border:1px solid #eee;">
        </div>
        @endif
    </div>

    {{-- FORM UMPAN BALIK --}}
    <div class="card">
        <div class="card-title">Umpan Balik & Update Status</div>

        @if($pengaduan->feedback)
        <div class="feedback-box" style="margin-bottom:20px;">
            <strong style="color:#1a3c5e;">Feedback Saat Ini:</strong>
            <p style="margin-top:8px; line-height:1.6;">{{ $pengaduan->feedback }}</p>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.pengaduan.updateStatus', $pengaduan->id) }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>Status Penyelesaian</label>
                <select name="status" class="form-control" required>
                    @foreach(['Menunggu','Proses','Selesai'] as $s)
                        <option value="{{ $s }}" {{ $pengaduan->status==$s ? 'selected' : '' }}>
                            {{ $s == 'Menunggu' ? '' : ($s == 'Proses' ? '' : '') }} {{ $s }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Umpan Balik / Keterangan untuk Siswa</label>
                <textarea name="feedback" class="form-control" rows="6"
                    placeholder="Tulis umpan balik atau progres penanganan pengaduan...">{{ old('feedback', $pengaduan->feedback) }}</textarea>
            </div>

            <button type="submit" class="btn btn-success" style="width:100%;">
                Simpan Status & Umpan Balik
            </button>
        </form>

        {{-- PROGRES TIMELINE --}}
        <div style="margin-top:25px; padding-top:20px; border-top:1px solid #eee;">
            <strong style="color:#555; font-size:0.9rem;">Progres Penanganan:</strong>
            @php
                $steps = ['Menunggu','Proses','Selesai'];
                $currentIdx = array_search($pengaduan->status, $steps);
            @endphp
            <div style="display:flex; margin-top:15px; position:relative;">
                @foreach($steps as $i => $step)
                <div style="flex:1; text-align:center; position:relative;">
                    <div style="
                        width:36px; height:36px; border-radius:50%; margin:0 auto;
                        display:flex; align-items:center; justify-content:center;
                        font-weight:bold; font-size:0.85rem;
                        background:{{ $i <= $currentIdx ? '#2d6a9f' : '#e9ecef' }};
                        color:{{ $i <= $currentIdx ? 'white' : '#999' }};
                        position:relative; z-index:1;
                    ">
                        {{ $i <= $currentIdx ? '✓' : ($i+1) }}
                    </div>
                    <div style="font-size:0.78rem; margin-top:6px; color:{{ $i <= $currentIdx ? '#1a3c5e' : '#999' }}; font-weight:{{ $i == $currentIdx ? 'bold' : 'normal' }};">
                        {{ $step }}
                    </div>
                    @if($i < count($steps)-1)
                    <div style="
                        position:absolute; top:18px; left:50%; width:100%; height:3px;
                        background:{{ $i < $currentIdx ? '#2d6a9f' : '#e9ecef' }};
                        z-index:0;
                    "></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
