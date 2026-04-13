<?php $__env->startSection('content'); ?>
<?php
    $user = auth()->user();
    $pengaduans = \App\Models\Pengaduan::where('user_id', $user->id)->get();
    $counts = [
        'total'    => $pengaduans->count(),
        'menunggu' => $pengaduans->where('status','Menunggu')->count(),
        'proses'   => $pengaduans->where('status','Proses')->count(),
        'selesai'  => $pengaduans->where('status','Selesai')->count(),
    ];
?>

<h2 style="color:#1a3c5e; margin-bottom:5px;">Halo, <?php echo e($user->name); ?>!</h2>
<p style="color:#666; margin-bottom:20px;">
    NIS: <strong><?php echo e($user->nis ?? '-'); ?></strong> &nbsp;|&nbsp;
    Kelas: <strong><?php echo e($user->kelas ?? '-'); ?></strong>
</p>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?php echo e($counts['total']); ?></div>
        <div class="stat-label">Total Pengaduan Saya</div>
    </div>
    <div class="stat-card menunggu">
        <div class="stat-number"><?php echo e($counts['menunggu']); ?></div>
        <div class="stat-label">Menunggu</div>
    </div>
    <div class="stat-card proses">
        <div class="stat-number"><?php echo e($counts['proses']); ?></div>
        <div class="stat-label">Diproses</div>
    </div>
    <div class="stat-card selesai">
        <div class="stat-number"><?php echo e($counts['selesai']); ?></div>
        <div class="stat-label">Selesai</div>
    </div>
</div>

<div class="card" style="text-align:center; padding:30px;">
    <p style="font-size:1.1rem; color:#555; margin-bottom:20px;">
        Sampaikan keluhan atau masukan terkait sarana dan prasarana sekolah
    </p>
    <a href="<?php echo e(route('siswa.pengaduan.create')); ?>" class="btn btn-primary" style="font-size:1rem; padding:12px 30px;">
        Buat Pengaduan Baru
    </a>
    &nbsp;&nbsp;
    <a href="<?php echo e(route('siswa.pengaduan.index')); ?>" class="btn" style="background:#6c757d; color:white; font-size:1rem; padding:12px 30px;">
        Lihat Riwayat Aspirasi
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pengaduan-sekolah\resources\views/siswa/dashboard.blade.php ENDPATH**/ ?>