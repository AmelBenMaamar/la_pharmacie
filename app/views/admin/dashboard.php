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

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <h1>🌿 La Pharmacie</h1>
            <span>Administration</span>
        </div>
        <nav class="sidebar-nav">
            <div class="sidebar-section">Contenu</div>
            <a href="<?= APP_URL ?>/admin" class="active">
                <span class="icon">🏠</span> Dashboard
            </a>
            <a href="<?= APP_URL ?>/admin/plantes">
                <span class="icon">🌿</span> Plantes
            </a>
            <a href="<?= APP_URL ?>/admin/composants">
                <span class="icon">🔬</span> Composants
            </a>
            <a href="<?= APP_URL ?>/admin/vertus">
                <span class="icon">✨</span> Vertus
            </a>
            <a href="<?= APP_URL ?>/admin/categories">
                <span class="icon">📂</span> Catégories
            </a>
            <div class="sidebar-section">Compte</div>
            <a href="<?= APP_URL ?>/logout">
                <span class="icon">🚪</span> Déconnexion
            </a>
        </nav>
        <div class="sidebar-footer">
            <small>Connecté : <?= htmlspecialchars($user['nom']) ?></small>
        </div>
    </aside>

    <!-- Contenu principal -->
    <main class="admin-main">
        <div class="page-header">
            <h2>Dashboard</h2>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🌿</div>
                <div class="stat-number"><?= $counts['plantes'] ?></div>
                <div class="stat-label">Plantes</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🔬</div>
                <div class="stat-number"><?= $counts['composants'] ?></div>
                <div class="stat-label">Composants</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✨</div>
                <div class="stat-number"><?= $counts['vertus'] ?></div>
                <div class="stat-label">Vertus</div>
            </div>
        </div>

        <!-- Actions rapides -->
        <h3 style="font-family: var(--font-serif); margin-bottom: 1rem;">Actions rapides</h3>
        <div class="stats-grid">
            <a href="<?= APP_URL ?>/admin/plantes/creer" class="stat-card" style="text-decoration:none;">
                <div class="stat-icon">➕</div>
                <div class="stat-label">Ajouter une plante</div>
            </a>
            <a href="<?= APP_URL ?>/admin/composants/creer" class="stat-card" style="text-decoration:none;">
                <div class="stat-icon">➕</div>
                <div class="stat-label">Ajouter un composant</div>
            </a>
            <a href="<?= APP_URL ?>/admin/vertus/creer" class="stat-card" style="text-decoration:none;">
                <div class="stat-icon">➕</div>
                <div class="stat-label">Ajouter une vertu</div>
            </a>
        </div>
    </main>

</div>
</body>
</html>
