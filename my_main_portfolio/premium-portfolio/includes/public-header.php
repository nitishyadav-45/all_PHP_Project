<?php
declare(strict_types=1);

$profile = $profile ?? profile_settings(db());
$pageTitle = $pageTitle ?? APP_NAME;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= e($profile['tagline'] ?? 'Professional portfolio website') ?>">
    <title><?= e($pageTitle) ?> | <?= e($profile['full_name'] ?? APP_NAME) ?></title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top public-nav" id="topNav">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= url('index.php') ?>">
            <span class="brand-mark">N</span><?= e($profile['full_name'] ?? 'Portfolio') ?>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fa-solid fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="<?= url('index.php#home') ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('index.php#about') ?>">About</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('index.php#services') ?>">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('index.php#portfolio') ?>">Projects</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('index.php#contact') ?>">Contact</a></li>
                <li class="nav-item ms-lg-2">
                    <a class="btn btn-sm nav-cta" href="<?= url('admin/login.php') ?>">
                        <i class="fa-solid fa-shield-halved me-1"></i> Admin
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main>

