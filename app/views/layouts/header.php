<?php $site = $settings ?? []; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars(($metaTitle ?? '') . ' | ' . ($site['site_name'] ?? 'Al Alameya'), ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription ?? '', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-navy sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/"><?= htmlspecialchars($site['site_name'] ?? 'Al Alameya', ENT_QUOTES, 'UTF-8') ?></a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <?php foreach ([
                    '/' => 'Home', '/about' => 'About', '/services' => 'Services', '/projects' => 'Projects', '/blog' => 'Blog', '/careers' => 'Careers', '/contact' => 'Contact'
                ] as $url => $label): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= $url ?>"><?= $label ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>
<main>
