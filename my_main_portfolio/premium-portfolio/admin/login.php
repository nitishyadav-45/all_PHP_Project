<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

if (is_admin_logged_in()) {
    redirect('admin/dashboard.php');
}

$needsSetup = admin_count(db()) === 0;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $needsSetup ? 'Create Admin' : 'Admin Login' ?> | <?= e(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="<?= asset('css/admin.css') ?>" rel="stylesheet">
</head>
<body class="login-body">
<main class="login-shell">
    <section class="login-panel animate__animated animate__fadeInUp">
        <div class="login-brand">
            <span>N</span>
            <div>
                <strong><?= e(APP_NAME) ?></strong>
                <small><?= $needsSetup ? 'First-run setup' : 'Secure dashboard access' ?></small>
            </div>
        </div>

        <?php if ($message = flash('error')): ?>
            <div class="alert alert-danger"><?= e($message) ?></div>
        <?php endif; ?>
        <?php if ($message = flash('success')): ?>
            <div class="alert alert-success"><?= e($message) ?></div>
        <?php endif; ?>

        <?php if ($needsSetup): ?>
            <h1>Create your admin account</h1>
            <p class="login-copy">No admin exists yet. Create the first account, then keep these credentials private.</p>
            <form action="<?= url('actions/login.php') ?>" method="post" class="login-form">
                <?= csrf_field() ?>
                <input type="hidden" name="mode" value="setup">
                <label>
                    Display name
                    <input type="text" name="display_name" class="form-control" required maxlength="120">
                </label>
                <label>
                    Username
                    <input type="text" name="username" class="form-control" required maxlength="60" autocomplete="username">
                </label>
                <label>
                    Email
                    <input type="email" name="email" class="form-control" required maxlength="160">
                </label>
                <label>
                    Password
                    <input type="password" name="password" class="form-control" required minlength="10" autocomplete="new-password">
                </label>
                <label>
                    Confirm password
                    <input type="password" name="password_confirmation" class="form-control" required minlength="10" autocomplete="new-password">
                </label>
                <button class="btn btn-admin-primary w-100" type="submit">
                    <i class="fa-solid fa-user-shield me-2"></i>Create Admin
                </button>
            </form>
        <?php else: ?>
            <h1>Welcome back</h1>
            <p class="login-copy">Sign in to manage projects, messages, site profile, and settings.</p>
            <form action="<?= url('actions/login.php') ?>" method="post" class="login-form">
                <?= csrf_field() ?>
                <input type="hidden" name="mode" value="login">
                <label>
                    Username or email
                    <input type="text" name="login" class="form-control" required autocomplete="username">
                </label>
                <label>
                    Password
                    <input type="password" name="password" class="form-control" required autocomplete="current-password">
                </label>
                <button class="btn btn-admin-primary w-100" type="submit">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Sign In
                </button>
            </form>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
