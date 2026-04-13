<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengaduan Sarana Sekolah</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f0f4f8; color: #333; }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(135deg, #1a3c5e, #2d6a9f);
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .navbar-brand { color: white; font-size: 1.2rem; font-weight: bold; text-decoration: none; }
        .navbar-nav { display: flex; gap: 5px; align-items: center; }
        .nav-link {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: background 0.2s;
        }
        .nav-link:hover { background: rgba(255,255,255,0.15); color: white; }
        .nav-link.active { background: rgba(255,255,255,0.2); color: white; }

        /* LOGOUT BTN */
        .btn-logout {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 7px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: background 0.2s;
        }
        .btn-logout:hover { background: rgba(255,0,0,0.3); }

        /* MAIN CONTENT */
        .main-content { padding: 30px; max-width: 1200px; margin: 0 auto; }

        /* CARD */
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 25px;
            margin-bottom: 20px;
        }
        .card-title { font-size: 1.3rem; font-weight: 600; color: #1a3c5e; margin-bottom: 15px; border-bottom: 2px solid #e8ecf0; padding-bottom: 10px; }

        /* ALERT */
        .alert { padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .alert-danger  { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }

        /* TABEL */
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        thead th { background: #1a3c5e; color: white; padding: 12px 10px; text-align: left; }
        tbody tr { border-bottom: 1px solid #e8ecf0; }
        tbody tr:hover { background: #f7f9fc; }
        tbody td { padding: 11px 10px; vertical-align: middle; }

        /* BADGE STATUS */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
        }
        .badge-warning  { background: #fff3cd; color: #856404; }
        .badge-info     { background: #cce5ff; color: #004085; }
        .badge-success  { background: #d4edda; color: #155724; }

        /* TOMBOL */
        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.88rem;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: opacity 0.2s;
        }
        .btn:hover { opacity: 0.85; }
        .btn-primary  { background: #2d6a9f; color: white; }
        .btn-success  { background: #28a745; color: white; }
        .btn-sm       { padding: 5px 11px; font-size: 0.82rem; }

        /* FORM */
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 6px; color: #444; }
        .form-control {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }
        .form-control:focus { outline: none; border-color: #2d6a9f; box-shadow: 0 0 0 3px rgba(45,106,159,0.15); }
        textarea.form-control { resize: vertical; min-height: 100px; }

        /* FILTER BAR */
        .filter-bar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: flex-end;
            background: white;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .filter-bar .form-group { margin-bottom: 0; flex: 1; min-width: 150px; }

        /* STATS CARD */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 25px; }
        .stat-card { background: white; border-radius: 10px; padding: 20px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
        .stat-card .stat-number { font-size: 2.2rem; font-weight: bold; color: #1a3c5e; }
        .stat-card .stat-label { font-size: 0.85rem; color: #666; margin-top: 5px; }
        .stat-card.menunggu .stat-number { color: #856404; }
        .stat-card.proses   .stat-number { color: #004085; }
        .stat-card.selesai  .stat-number { color: #155724; }

        /* PAGINATION */
        .pagination-wrapper { margin-top: 15px; display: flex; justify-content: center; }
        .pagination-wrapper .pagination { list-style: none; display: flex; gap: 5px; }
        .pagination-wrapper .page-link { padding: 6px 12px; border: 1px solid #ced4da; border-radius: 5px; color: #2d6a9f; text-decoration: none; }
        .pagination-wrapper .page-item.active .page-link { background: #2d6a9f; color: white; border-color: #2d6a9f; }

        /* DETAIL PAGE */
        .detail-row { display: flex; gap: 10px; padding: 10px 0; border-bottom: 1px solid #eee; }
        .detail-label { font-weight: 600; color: #555; width: 160px; flex-shrink: 0; }
        .detail-value { color: #333; }
        .feedback-box { background: #f0f8ff; border-left: 4px solid #2d6a9f; padding: 15px; border-radius: 6px; margin-top: 15px; }

        /* PROGRESS BAR */
        .progress-container { margin: 20px 0; }
        .progress-bar-wrap { height: 12px; background: #e9ecef; border-radius: 6px; overflow: hidden; }
        .progress-bar-fill { height: 100%; background: linear-gradient(90deg, #28a745, #20c997); border-radius: 6px; transition: width 0.5s; }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="#" class="navbar-brand">Sistem Pengaduan Sekolah</a>

    <div style="display:flex; align-items:center; gap:15px;">
        <?php if(auth()->guard()->check()): ?>
        <div class="navbar-nav">
            <?php if(auth()->user()->role == 'admin'): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link">Dashboard</a>
                <a href="<?php echo e(route('admin.pengaduan.index')); ?>" class="nav-link">Data Pengaduan</a>
            <?php endif; ?>
            <?php if(auth()->user()->role == 'siswa'): ?>
                <a href="<?php echo e(route('siswa.dashboard')); ?>" class="nav-link">Beranda</a>
                <a href="<?php echo e(route('siswa.pengaduan.index')); ?>" class="nav-link">Riwayat Aspirasi</a>
                <a href="<?php echo e(route('siswa.pengaduan.create')); ?>" class="nav-link">Buat Pengaduan</a>
            <?php endif; ?>
        </div>
        <span style="color:rgba(255,255,255,0.7); font-size:0.85rem;">
            👤 <?php echo e(auth()->user()->name); ?>

        </span>
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="display:inline;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn-logout">Logout</button>
        </form>
        <?php endif; ?>
    </div>
</nav>

<div class="main-content">
    <?php echo $__env->yieldContent('content'); ?>
</div>

</body>
</html>
<?php /**PATH C:\laragon\www\pengaduan-sekolah\resources\views/layouts/app.blade.php ENDPATH**/ ?>