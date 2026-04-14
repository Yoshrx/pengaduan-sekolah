<?php $__env->startSection('content'); ?>
<div style="margin-bottom:15px;">
    <a href="<?php echo e(route('admin.pengaduan.index')); ?>" style="color:#2d6a9f; text-decoration:none;">← Kembali ke Daftar</a>
</div>

<h2 style="color:#1a3c5e; margin-bottom:20px;">Detail Pengaduan</h2>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
    
    <div class="card">
        <div class="card-title">Informasi Pengaduan</div>

        <div class="detail-row">
            <span class="detail-label">Tanggal</span>
            <span class="detail-value"><?php echo e($pengaduan->tanggal_format); ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Nama Siswa</span>
            <span class="detail-value"><?php echo e($pengaduan->user->name); ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">NIS</span>
            <span class="detail-value"><?php echo e($pengaduan->user->nis ?? '-'); ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Kelas</span>
            <span class="detail-value"><?php echo e($pengaduan->user->kelas ?? '-'); ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Kategori</span>
            <span class="detail-value"><?php echo e($pengaduan->kategori->nama_kategori ?? '-'); ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Judul</span>
            <span class="detail-value"><strong><?php echo e($pengaduan->judul); ?></strong></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Lokasi</span>
            <span class="detail-value"><?php echo e($pengaduan->lokasi ?? '-'); ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Status</span>
            <span class="detail-value">
                <span class="badge <?php echo e($pengaduan->badge_status); ?>"><?php echo e($pengaduan->status); ?></span>
            </span>
        </div>
        <div style="margin-top:15px;">
            <div class="detail-label" style="margin-bottom:8px;">Isi Pengaduan</div>
            <div style="background:#f8f9fa; padding:15px; border-radius:8px; line-height:1.6;">
                <?php echo e($pengaduan->isi_pengaduan); ?>

            </div>
        </div>

        <?php if($pengaduan->foto): ?>
        <div style="margin-top:15px;">
            <div class="detail-label" style="margin-bottom:8px;">Foto Bukti</div>
            <img src="<?php echo e(asset('storage/' . $pengaduan->foto)); ?>"
                 style="max-width:100%; border-radius:8px; border:1px solid #eee;">
        </div>
        <?php endif; ?>
    </div>

    
    <div class="card">
        <div class="card-title">Umpan Balik & Update Status</div>

        <?php if($pengaduan->feedback): ?>
        <div class="feedback-box" style="margin-bottom:20px;">
            <strong style="color:#1a3c5e;">Feedback Saat Ini:</strong>
            <p style="margin-top:8px; line-height:1.6;"><?php echo e($pengaduan->feedback); ?></p>
        </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.pengaduan.updateStatus', $pengaduan->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>

            <div class="form-group">
                <label>Status Penyelesaian</label>
                <select name="status" class="form-control" required>
                    <?php $__currentLoopData = ['Menunggu','Proses','Selesai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e($pengaduan->status==$s ? 'selected' : ''); ?>>
                            <?php echo e($s == 'Menunggu' ? '' : ($s == 'Proses' ? '' : '')); ?> <?php echo e($s); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label>Umpan Balik / Keterangan untuk Siswa</label>
                <textarea name="feedback" class="form-control" rows="6"
                    placeholder="Tulis umpan balik atau progres penanganan pengaduan..."><?php echo e(old('feedback', $pengaduan->feedback)); ?></textarea>
            </div>

            <button type="submit" class="btn btn-success" style="width:100%;">
                Simpan Status & Umpan Balik
            </button>
        </form>

        
        <div style="margin-top:25px; padding-top:20px; border-top:1px solid #eee;">
            <strong style="color:#555; font-size:0.9rem;">Progres Penanganan:</strong>
            <?php
                $steps = ['Menunggu','Proses','Selesai'];
                $currentIdx = array_search($pengaduan->status, $steps);
            ?>
            <div style="display:flex; margin-top:15px; position:relative;">
                <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="flex:1; text-align:center; position:relative;">
                    <div style="
                        width:36px; height:36px; border-radius:50%; margin:0 auto;
                        display:flex; align-items:center; justify-content:center;
                        font-weight:bold; font-size:0.85rem;
                        background:<?php echo e($i <= $currentIdx ? '#2d6a9f' : '#e9ecef'); ?>;
                        color:<?php echo e($i <= $currentIdx ? 'white' : '#999'); ?>;
                        position:relative; z-index:1;
                    ">
                        <?php echo e($i <= $currentIdx ? '✓' : ($i+1)); ?>

                    </div>
                    <div style="font-size:0.78rem; margin-top:6px; color:<?php echo e($i <= $currentIdx ? '#1a3c5e' : '#999'); ?>; font-weight:<?php echo e($i == $currentIdx ? 'bold' : 'normal'); ?>;">
                        <?php echo e($step); ?>

                    </div>
                    <?php if($i < count($steps)-1): ?>
                    <div style="
                        position:absolute; top:18px; left:50%; width:100%; height:3px;
                        background:<?php echo e($i < $currentIdx ? '#2d6a9f' : '#e9ecef'); ?>;
                        z-index:0;
                    "></div>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pengaduan-sekolah\resources\views/admin/detail_pengaduan.blade.php ENDPATH**/ ?>