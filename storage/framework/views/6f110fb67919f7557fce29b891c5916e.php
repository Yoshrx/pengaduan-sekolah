<?php $__env->startSection('content'); ?>
<div style="margin-bottom:15px;">
    <a href="<?php echo e(route('siswa.pengaduan.index')); ?>" style="color:#2d6a9f; text-decoration:none;">← Kembali</a>
</div>

<h2 style="color:#1a3c5e; margin-bottom:20px;">Form Aspirasi / Pengaduan</h2>

<div class="card" style="max-width:700px;">
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul style="list-style:none;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('siswa.pengaduan.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label>Kategori Sarana <span style="color:red;">*</span></label>
            <select name="kategori_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($kat->id); ?>" <?php echo e(old('kategori_id')==$kat->id?'selected':''); ?>>
                        <?php echo e($kat->nama_kategori); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="form-group">
            <label>Judul Pengaduan <span style="color:red;">*</span></label>
            <input type="text" name="judul" class="form-control"
                   placeholder="Contoh: Keran air di toilet rusak"
                   value="<?php echo e(old('judul')); ?>" required>
        </div>

        <div class="form-group">
            <label>Lokasi <span style="color:#aaa; font-weight:normal;">(opsional)</span></label>
            <input type="text" name="lokasi" class="form-control"
                   placeholder="Contoh: Toilet Lantai 2, Kelas XII RPL 1"
                   value="<?php echo e(old('lokasi')); ?>">
        </div>

        <div class="form-group">
            <label>Isi Pengaduan / Aspirasi <span style="color:red;">*</span></label>
            <textarea name="isi_pengaduan" class="form-control" rows="6"
                placeholder="Jelaskan secara detail masalah atau masukan yang ingin disampaikan..." required><?php echo e(old('isi_pengaduan')); ?></textarea>
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
            <a href="<?php echo e(route('siswa.pengaduan.index')); ?>" class="btn" style="background:#6c757d; color:white; padding:12px 20px;">
                Batal
            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pengaduan-sekolah\resources\views/siswa/create_pengaduan.blade.php ENDPATH**/ ?>