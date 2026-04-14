<?php $__env->startSection('content'); ?>
<h2 style="color:#1a3c5e; margin-bottom:20px;">Dashboard Admin</h2>


<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?php echo e($statistik['total']); ?></div>
        <div class="stat-label">Total Pengaduan</div>
    </div>
    <div class="stat-card menunggu">
        <div class="stat-number"><?php echo e($statistik['menunggu']); ?></div>
        <div class="stat-label">Menunggu</div>
    </div>
    <div class="stat-card proses">
        <div class="stat-number"><?php echo e($statistik['proses']); ?></div>
        <div class="stat-label">Sedang Diproses</div>
    </div>
    <div class="stat-card selesai">
        <div class="stat-number"><?php echo e($statistik['selesai']); ?></div>
        <div class="stat-label">Selesai</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
    
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
                <?php $__empty_1 = true; $__currentLoopData = $terbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($p->user->name); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.pengaduan.show', $p->id)); ?>" style="color:#2d6a9f; text-decoration:none;">
                            <?php echo e(Str::limit($p->judul, 30)); ?>

                        </a>
                    </td>
                    <td>
                        <span class="badge <?php echo e($p->badge_status); ?>"><?php echo e($p->status); ?></span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="3" style="text-align:center; color:#999;">Belum ada pengaduan</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div style="margin-top:15px;">
            <a href="<?php echo e(route('admin.pengaduan.index')); ?>" class="btn btn-primary btn-sm">Lihat Semua →</a>
        </div>
    </div>

    
    <div class="card">
        <div class="card-title">Pengaduan per Kategori</div>
        <?php if(count($perKategori) > 0): ?>
            <?php $__currentLoopData = $perKategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nama => $jumlah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $pct = $statistik['total'] > 0 ? round($jumlah/$statistik['total']*100) : 0; ?>
            <div style="margin-bottom:14px;">
                <div style="display:flex; justify-content:space-between; font-size:0.88rem; margin-bottom:5px;">
                    <span><?php echo e($nama); ?></span>
                    <strong><?php echo e($jumlah); ?></strong>
                </div>
                <div class="progress-bar-wrap">
                    <div class="progress-bar-fill" style="width:<?php echo e($pct); ?>%;"></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <p style="color:#999; text-align:center;">Belum ada data kategori</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pengaduan-sekolah\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>