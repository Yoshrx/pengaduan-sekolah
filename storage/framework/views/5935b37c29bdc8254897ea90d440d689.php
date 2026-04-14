<?php $__env->startSection('content'); ?>
<div style="margin-bottom:15px;">
    <a href="<?php echo e(route('siswa.pengaduan.index')); ?>" style="color:#2d6a9f; text-decoration:none;">← Kembali ke Riwayat</a>
</div>

<h2 style="color:#1a3c5e; margin-bottom:20px;">Detail Aspirasi</h2>

<div class="card">
    <div class="detail-row">
        <span class="detail-label">Tanggal Dikirim</span>
        <span class="detail-value"><?php echo e($pengaduan->tanggal_format); ?></span>
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
             style="max-width:500px; border-radius:8px; border:1px solid #eee;">
    </div>
    <?php endif; ?>
</div>


<div class="card">
    <div class="card-title">Progres Penanganan</div>
    <?php
        $steps = ['Menunggu','Proses','Selesai'];
        $currentIdx = array_search($pengaduan->status, $steps);
    ?>
    <div style="display:flex; margin-top:10px; position:relative; max-width:500px;">
        <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="flex:1; text-align:center; position:relative;">
            <div style="
                width:40px; height:40px; border-radius:50%; margin:0 auto;
                display:flex; align-items:center; justify-content:center;
                font-weight:bold;
                background:<?php echo e($i <= $currentIdx ? '#2d6a9f' : '#e9ecef'); ?>;
                color:<?php echo e($i <= $currentIdx ? 'white' : '#999'); ?>;
                position:relative; z-index:1;
            "><?php echo e($i <= $currentIdx ? '✓' : ($i+1)); ?></div>
            <div style="font-size:0.85rem; margin-top:8px; color:<?php echo e($i <= $currentIdx ? '#1a3c5e' : '#999'); ?>; font-weight:<?php echo e($i==$currentIdx?'bold':'normal'); ?>;">
                <?php echo e($step); ?>

            </div>
            <?php if($i < count($steps)-1): ?>
            <div style="position:absolute; top:20px; left:50%; width:100%; height:3px; background:<?php echo e($i < $currentIdx ? '#2d6a9f' : '#e9ecef'); ?>; z-index:0;"></div>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>


<div class="card">
    <div class="card-title">Umpan Balik dari Admin</div>
    <?php if($pengaduan->feedback): ?>
        <div class="feedback-box">
            <p style="line-height:1.7; color:#333;"><?php echo e($pengaduan->feedback); ?></p>
        </div>
    <?php else: ?>
        <div style="text-align:center; padding:20px; color:#999;">
            <p>Belum ada umpan balik dari admin. Pengaduan Anda sedang ditinjau.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pengaduan-sekolah\resources\views/siswa/detail_pengaduan.blade.php ENDPATH**/ ?>