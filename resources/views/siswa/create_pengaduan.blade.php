@extends('layouts.app')

@section('content')
<div style="margin-bottom:15px;">
    <a href="{{ route('siswa.pengaduan.index') }}" style="color:#2d6a9f; text-decoration:none;">← Kembali</a>
</div>

<h2 style="color:#1a3c5e; margin-bottom:20px;">Form Aspirasi / Pengaduan</h2>

<div class="card" style="max-width:700px;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="list-style:none;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('siswa.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Kategori Sarana <span style="color:red;">*</span></label>
            <select name="kategori_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" {{ old('kategori_id')==$kat->id?'selected':'' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Judul Pengaduan <span style="color:red;">*</span></label>
            <input type="text" name="judul" class="form-control"
                   placeholder="Contoh: Keran air di toilet rusak"
                   value="{{ old('judul') }}" required>
        </div>

        <div class="form-group">
            <label>Lokasi <span style="color:#aaa; font-weight:normal;">(opsional)</span></label>
            <input type="text" name="lokasi" class="form-control"
                   placeholder="Contoh: Toilet Lantai 2, Kelas XII RPL 1"
                   value="{{ old('lokasi') }}">
        </div>

        <div class="form-group">
            <label>Isi Pengaduan / Aspirasi <span style="color:red;">*</span></label>
            <textarea name="isi_pengaduan" class="form-control" rows="6"
                placeholder="Jelaskan secara detail masalah atau masukan yang ingin disampaikan..." required>{{ old('isi_pengaduan') }}</textarea>
        </div>

        <div class="form-group">
            <label>Foto Bukti <span style="color:#aaa; font-weight:normal;">(opsional, maks 2MB)</span></label>
            <input type="file" name="foto" class="form-control" accept="image/jpg,image/jpeg,image/png">
            <small style="color:#888;">Format: JPG, JPEG, PNG</small>
        </div>

        <div style="display:flex; gap:10px; margin-top:10px;">
            <button type="submit" class="btn btn-success" style="flex:1; padding:12px;">
                Kirim Pengaduan
            </button>
            <a href="{{ route('siswa.pengaduan.index') }}" class="btn" style="background:#6c757d; color:white; padding:12px 20px;">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
