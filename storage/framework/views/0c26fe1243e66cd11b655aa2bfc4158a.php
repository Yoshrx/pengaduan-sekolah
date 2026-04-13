<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pengaduan Sekolah</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: linear-gradient(135deg, #1a3c5e 0%, #2d6a9f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            width: 400px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        .login-header { text-align: center; margin-bottom: 30px; }
        .login-header .icon { font-size: 3rem; margin-bottom: 10px; }
        .login-header h1 { font-size: 1.5rem; color: #1a3c5e; }
        .login-header p { color: #777; font-size: 0.9rem; margin-top: 5px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 6px; color: #444; }
        .form-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #ced4da;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }
        .form-group input:focus { outline: none; border-color: #2d6a9f; box-shadow: 0 0 0 3px rgba(45,106,159,0.15); }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1a3c5e, #2d6a9f);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-login:hover { opacity: 0.9; }
        .alert-error { background: #f8d7da; color: #721c24; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; border-left: 4px solid #dc3545; font-size: 0.9rem; }
        .demo-accounts { margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee; }
        .demo-accounts p { font-size: 0.8rem; color: #777; text-align: center; margin-bottom: 10px; }
        .demo-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .demo-item { background: #f8f9fa; border-radius: 6px; padding: 10px; font-size: 0.78rem; }
        .demo-item strong { color: #1a3c5e; display: block; margin-bottom: 4px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="icon"></div>
            <h1>Sistem Pengaduan</h1>
            <p>Sarana & Prasarana Sekolah</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert-error">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert-error"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <form method="POST" action="/login">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Masukkan email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn-login">Masuk</button>
        </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\pengaduan-sekolah\resources\views/auth/login.blade.php ENDPATH**/ ?>