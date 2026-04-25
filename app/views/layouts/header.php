<?php require APP_ROOT . '/app/views/layouts/icons.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'La Pharmacie') ?> — La Pharmacie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body class="public-page">

    <header class="public-header">
        <div class="public-header-inner">
            <a href="<?= APP_URL ?>/" class="public-logo">
                <?= icon('plante', 22, 'logo-icon') ?>
                <span>La Pharmacie</span>
            </a>
            <nav class="public-nav">
                <a href="<?= APP_URL ?>/plantes">Plantes</a>
                <a href="<?= APP_URL ?>/composants">Composants</a>
                <a href="<?= APP_URL ?>/vertus">Vertus</a>
                <?php $user = $_SESSION['user'] ?? null; ?>
                <?php if ($user): ?>
                    <?php if ($user['role'] === 'admin'): ?>
                        <a href="<?= APP_URL ?>/admin" class="btn btn-primary btn-sm">Admin</a>
                    <?php endif; ?>
                    <a href="<?= APP_URL ?>/logout" class="btn btn-secondary btn-sm">Déconnexion</a>
                <?php else: ?>
                    <a href="<?= APP_URL ?>/login" class="btn btn-primary btn-sm">Connexion</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
