<?php $__env->startSection('content'); ?>
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 style="color:#1a3c5e;">Riwayat Aspirasi Saya</h2>
    <a href="<?php echo e(route('siswa.pengaduan.create')); ?>" class="btn btn-primary">+ Buat Pengaduan Baru</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<div class="card">
    <?php if($pengaduans->count() > 0): ?>
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
            <?php $__currentLoopData = $pengaduans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($pengaduans->firstItem() + $index); ?></td>
                <td style="white-space:nowrap;"><?php echo e($p->tanggal_format); ?></td>
                <td><?php echo e(Str::limit($p->judul, 40)); ?></td>
                <td><?php echo e($p->kategori->nama_kategori ?? '-'); ?></td>
                <td><span class="badge <?php echo e($p->badge_status); ?>"><?php echo e($p->status); ?></span></td>
                <td>
                    <?php if($p->feedback): ?>
                        <span style="color:#28a745; font-size:0.85rem;">Ada umpan balik</span>
                    <?php else: ?>
                        <span style="color:#999; font-size:0.85rem;">-</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo e(route('siswa.pengaduan.show', $p->id)); ?>" class="btn btn-primary btn-sm">Detail</a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class="pagination-wrapper">
        <?php echo e($pengaduans->links()); ?>

    </div>
    <?php else: ?>
    <div style="text-align:center; padding:40px; color:#999;">
        <div style="font-size:3rem; margin-bottom:15px;"></div>
        <p>Belum ada pengaduan yang dikirim.</p>
        <a href="<?php echo e(route('siswa.pengaduan.create')); ?>" class="btn btn-primary" style="margin-top:15px;">Buat Pengaduan Pertama</a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pengaduan-sekolah\resources\views/siswa/pengaduan_index.blade.php ENDPATH**/ ?>