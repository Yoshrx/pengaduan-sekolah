<?php $__env->startSection('content'); ?>
<h2 style="color:#1a3c5e; margin-bottom:20px;">Data Pengaduan Siswa</h2>

<?php if(session('success')): ?>
    <div class="alert alert-success"> <?php echo e(session('success')); ?></div>
<?php endif; ?>


<form method="GET" class="filter-bar">
    <div class="form-group">
        <label>Cari Judul</label>
        <input type="text" name="search" class="form-control" placeholder="Kata kunci..." value="<?php echo e(request('search')); ?>">
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="">Semua Status</option>
            <?php $__currentLoopData = ['Menunggu','Proses','Selesai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s); ?>" <?php echo e(request('status')==$s?'selected':''); ?>><?php echo e($s); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="form-group">
        <label>Kategori</label>
        <select name="kategori_id" class="form-control">
            <option value="">Semua Kategori</option>
            <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($kat->id); ?>" <?php echo e(request('kategori_id')==$kat->id?'selected':''); ?>><?php echo e($kat->nama_kategori); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="form-group">
        <label>Siswa</label>
        <select name="user_id" class="form-control">
            <option value="">Semua Siswa</option>
            <?php $__currentLoopData = $siswas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s->id); ?>" <?php echo e(request('user_id')==$s->id?'selected':''); ?>><?php echo e($s->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="form-group">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="<?php echo e(request('tanggal')); ?>">
    </div>
    <div class="form-group">
        <label>Bulan</label>
        <input type="month" name="bulan" class="form-control" value="<?php echo e(request('bulan')); ?>">
    </div>
    <div style="display:flex; gap:8px; align-items:flex-end;">
        <button type="submit" class="btn btn-primary"> Filter</button>
        <a href="<?php echo e(route('admin.pengaduan.index')); ?>" class="btn" style="background:#6c757d; color:white;">Reset</a>
    </div>
</form>


<div class="card">
    <p style="font-size:0.85rem; color:#666; margin-bottom:15px;">
        Menampilkan <?php echo e($pengaduans->total()); ?> pengaduan
    </p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $pengaduans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($pengaduans->firstItem() + $loop->index); ?></td>
                <td style="white-space:nowrap;"><?php echo e($p->tanggal_format); ?></td>
                <td><?php echo e($p->user->name); ?></td>
                <td><?php echo e($p->user->kelas ?? '-'); ?></td>
                <td><?php echo e(Str::limit($p->judul, 40)); ?></td>
                <td><?php echo e($p->kategori->nama_kategori ?? '-'); ?></td>
                <td><span class="badge <?php echo e($p->badge_status); ?>"><?php echo e($p->status); ?></span></td>
                <td>
                    <a href="<?php echo e(route('admin.pengaduan.show', $p->id)); ?>" class="btn btn-primary btn-sm">Detail & Feedback</a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" style="text-align:center; color:#999; padding:30px;">Tidak ada data pengaduan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="pagination-wrapper">
        <?php echo e($pengaduans->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pengaduan-sekolah\resources\views\admin\pengaduan_index.blade.php ENDPATH**/ ?>