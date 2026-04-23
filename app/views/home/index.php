<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Pharmacie — Herbier interactif</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body class="public-page">

    <!-- Header -->
    <header class="public-header">
        <div class="public-header-inner">
            <a href="<?= APP_URL ?>/" class="public-logo">
                🌿 <span>La Pharmacie</span>
            </a>
            <nav class="public-nav">
                <a href="<?= APP_URL ?>/#plantes">Plantes</a>
                <a href="<?= APP_URL ?>/#composants">Composants</a>
                <a href="<?= APP_URL ?>/#vertus">Vertus</a>
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

    <!-- Hero -->
    <section class="hero">
        <div class="hero-inner">
            <h1 class="hero-title">La Pharmacie</h1>
            <p class="hero-subtitle">Explorez les plantes, leurs composants actifs et leurs vertus thérapeutiques</p>

            <!-- Catégories -->
            <div class="categories-bar">
                <?php foreach ($categories as $cat): ?>
                    <a href="#plantes" class="category-pill"
                       style="background:<?= htmlspecialchars($cat['couleur']) ?>22;border-color:<?= htmlspecialchars($cat['couleur']) ?>44;color:<?= htmlspecialchars($cat['couleur']) ?>">
                        <?= htmlspecialchars($cat['nom']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <main class="public-main">

        <!-- Plantes -->
        <section id="plantes" class="public-section">
            <h2 class="section-title">🌿 Plantes <span><?= count($plantes) ?></span></h2>
            <div class="cards-grid">
                <?php if (empty($plantes)): ?>
                    <p style="color:var(--texte-light)">Aucune plante pour l'instant.</p>
                <?php else: ?>
                    <?php foreach ($plantes as $p): ?>
                        <?php if (!$p['actif']) continue; ?>
                        <a href="<?= APP_URL ?>/plantes/<?= htmlspecialchars($p['slug']) ?>" class="public-card">
                            <div class="public-card-img">
                                <?php if ($p['image']): ?>
                                    <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($p['image']) ?>"
                                         alt="<?= htmlspecialchars($p['nom']) ?>">
                                <?php else: ?>
                                    <div class="public-card-placeholder">🌿</div>
                                <?php endif; ?>
                            </div>
                            <div class="public-card-body">
                                <h3><?= htmlspecialchars($p['nom']) ?></h3>
                                <?php if ($p['nom_latin']): ?>
                                    <em><?= htmlspecialchars($p['nom_latin']) ?></em>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- Composants -->
        <section id="composants" class="public-section">
            <h2 class="section-title">🔬 Composants <span><?= count($composants) ?></span></h2>
            <div class="tags-cloud">
                <?php foreach ($composants as $c): ?>
                    <?php if (!$c['actif']) continue; ?>
                    <a href="<?= APP_URL ?>/composants/<?= htmlspecialchars($c['slug']) ?>"
                       class="tag tag-composant tag-lg">
                        <?= htmlspecialchars($c['nom']) ?>
                        <?php if ($c['famille']): ?>
                            <small><?= htmlspecialchars($c['famille']) ?></small>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Vertus -->
        <section id="vertus" class="public-section">
            <h2 class="section-title">✨ Vertus <span><?= count($vertus) ?></span></h2>
            <div class="tags-cloud">
                <?php foreach ($vertus as $v): ?>
                    <?php if (!$v['actif']) continue; ?>
                    <a href="<?= APP_URL ?>/vertus/<?= htmlspecialchars($v['slug']) ?>"
                       class="tag tag-vertu tag-lg">
                        <?= htmlspecialchars($v['nom']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

    </main>

    <footer class="public-footer">
        <p>🌿 La Pharmacie — Herbier interactif © <?= date('Y') ?> AmelCerise</p>
    </footer>

</body>
</html>
