<?php require_once APP_ROOT . '/app/views/layouts/icons.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — La Pharmacie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
<div class="admin-layout">

    <?php include __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="admin-main">

        <div class="page-header">
            <div>
                <h2>Dashboard</h2>
                <p style="color:var(--texte-light);font-size:0.85rem;margin-top:0.25rem;">
                    Bonjour <?= htmlspecialchars($user['nom']) ?> — <?= date('d/m/Y') ?>
                </p>
            </div>
            <a href="<?= APP_URL ?>/" class="btn btn-secondary btn-sm" target="_blank">
                Voir le site →
            </a>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <a href="<?= APP_URL ?>/admin/plantes" class="stat-card stat-card-link">
                <div class="stat-icon"><?= icon('plante', 28, 'stat-svg plante') ?></div>
                <div class="stat-number"><?= $counts['plantes'] ?></div>
                <div class="stat-label">Plantes</div>
            </a>
            <a href="<?= APP_URL ?>/admin/composants" class="stat-card stat-card-link">
                <div class="stat-icon"><?= icon('composant', 28, 'stat-svg composant') ?></div>
                <div class="stat-number"><?= $counts['composants'] ?></div>
                <div class="stat-label">Composants</div>
            </a>
            <a href="<?= APP_URL ?>/admin/vertus" class="stat-card stat-card-link">
                <div class="stat-icon"><?= icon('vertu', 28, 'stat-svg vertu') ?></div>
                <div class="stat-number"><?= $counts['vertus'] ?></div>
                <div class="stat-label">Vertus</div>
            </a>
            <a href="<?= APP_URL ?>/admin/sources" class="stat-card stat-card-link">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         class="stat-svg source">
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                    </svg>
                </div>
                <div class="stat-number"><?= $counts['sources'] ?></div>
                <div class="stat-label">Sources</div>
            </a>
        </div>

        <!-- Actions rapides -->
        <div class="admin-section-title">Actions rapides</div>
        <div class="quick-actions">
            <a href="<?= APP_URL ?>/admin/plantes/creer" class="quick-action">
                <div class="quick-action-icon"><?= icon('plante', 22, 'plante') ?></div>
                <div>
                    <div class="quick-action-title">Nouvelle plante</div>
                    <div class="quick-action-sub">Ajouter à l'herbier</div>
                </div>
            </a>
            <a href="<?= APP_URL ?>/admin/composants/creer" class="quick-action">
                <div class="quick-action-icon"><?= icon('composant', 22, 'composant') ?></div>
                <div>
                    <div class="quick-action-title">Nouveau composant</div>
                    <div class="quick-action-sub">Ajouter un actif</div>
                </div>
            </a>
            <a href="<?= APP_URL ?>/admin/vertus/creer" class="quick-action">
                <div class="quick-action-icon"><?= icon('vertu', 22, 'vertu') ?></div>
                <div>
                    <div class="quick-action-title">Nouvelle vertu</div>
                    <div class="quick-action-sub">Ajouter un bienfait</div>
                </div>
            </a>
        </div>

    </main>
</div>
</body>
</html>
