<?php
declare(strict_types=1);

$admin = $admin ?? current_admin(db());
$adminPageTitle = $adminPageTitle ?? 'Dashboard';
?>
<!doctype html>
<html lang="en" data-admin-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($adminPageTitle) ?> | <?= e(APP_NAME) ?> Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="<?= asset('css/admin.css') ?>" rel="stylesheet">
</head>
<body>
<div class="admin-layout">
    <aside class="admin-sidebar" id="adminSidebar">
        <a class="admin-brand" href="<?= url('admin/dashboard.php') ?>">
            <span>N</span>
            <strong>Nova Admin</strong>
        </a>
        <nav class="admin-menu">
            <a href="<?= url('admin/dashboard.php') ?>" class="<?= ($activeMenu ?? '') === 'dashboard' ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-pie"></i> Overview
            </a>
            <a href="<?= url('admin/projects.php') ?>" class="<?= ($activeMenu ?? '') === 'projects' ? 'active' : '' ?>">
                <i class="fa-solid fa-layer-group"></i> Portfolio
            </a>
            <a href="<?= url('admin/messages.php') ?>" class="<?= ($activeMenu ?? '') === 'messages' ? 'active' : '' ?>">
                <i class="fa-solid fa-inbox"></i> Messages
            </a>
            <a href="<?= url('admin/settings.php') ?>" class="<?= ($activeMenu ?? '') === 'settings' ? 'active' : '' ?>">
                <i class="fa-solid fa-gear"></i> Settings
            </a>
        </nav>
        <div class="sidebar-footer">
            <a class="btn btn-sm btn-outline-admin w-100" href="<?= url('index.php') ?>" target="_blank">
                <i class="fa-solid fa-up-right-from-square me-2"></i>View Site
            </a>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <button class="icon-button d-lg-none" type="button" id="sidebarToggle" aria-label="Toggle sidebar">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div>
                <span class="topbar-kicker">Dashboard</span>
                <h1><?= e($adminPageTitle) ?></h1>
            </div>
            <div class="topbar-actions">
                <button class="icon-button" type="button" id="themeToggle" aria-label="Toggle theme">
                    <i class="fa-solid fa-moon"></i>
                </button>
                <div class="admin-user">
                    <div class="admin-avatar"><?= e(strtoupper(substr($admin['display_name'] ?? $admin['username'] ?? 'A', 0, 1))) ?></div>
                    <div>
                        <strong><?= e($admin['display_name'] ?? 'Admin') ?></strong>
                        <span><?= e($admin['email'] ?? '') ?></span>
                    </div>
                </div>
                <form action="<?= url('actions/logout.php') ?>" method="post">
                    <?= csrf_field() ?>
                    <button class="icon-button danger" type="submit" aria-label="Logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </header>

        <div class="admin-content">
            <?php if ($message = flash('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= e($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if ($message = flash('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= e($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

