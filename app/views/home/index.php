<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<section class="hero">
    <div class="hero-inner">
        <h1 class="hero-title">La Pharmacie</h1>
        <p class="hero-subtitle">Explorez les plantes, leurs composants actifs et leurs vertus thérapeutiques</p>

        <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input
                type="search"
                id="search-plantes"
                placeholder="Rechercher une plante, nom latin…"
                autocomplete="off"
                spellcheck="false"
            >
        </div>

        <div class="categories-bar">
            <?php foreach ($categories as $cat): ?>
                <button
                    class="category-pill"
                    data-cat="<?= htmlspecialchars($cat['nom']) ?>"
                    style="background:<?= htmlspecialchars($cat['couleur']) ?>22;border-color:<?= htmlspecialchars($cat['couleur']) ?>44;color:<?= htmlspecialchars($cat['couleur']) ?>"
                >
                    <?= htmlspecialchars($cat['nom']) ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<main class="public-main">

    <section id="plantes" class="public-section">
        <h2 class="section-title">
            <?= icon('plante', 20, 'section-icon plante') ?> Plantes
            <span><?= count(array_filter($plantes, fn($p) => $p['actif'])) ?></span>
        </h2>

        <div class="cards-grid">
            <?php if (empty($plantes)): ?>
                <p style="color:var(--texte-light)">Aucune plante pour l'instant.</p>
            <?php else: ?>
                <?php foreach ($plantes as $p): ?>
                    <?php if (!$p['actif']) continue; ?>
                    <?php
                        $cats     = $cats_par_plante[$p['id']] ?? [];
                        $dataCats = implode(',', array_column($cats, 'nom'));
                    ?>
                    <a href="<?= APP_URL ?>/plantes/<?= htmlspecialchars($p['slug']) ?>"
                       class="public-card"
                       data-cats="<?= htmlspecialchars($dataCats) ?>"
                       data-nom="<?= htmlspecialchars(strtolower($p['nom'])) ?>"
                       data-latin="<?= htmlspecialchars(strtolower($p['nom_latin'] ?? '')) ?>">
                        <div class="public-card-img">
                            <?php if ($p['image']): ?>
                                <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($p['image']) ?>"
                                     alt="<?= htmlspecialchars($p['nom']) ?>">
                            <?php else: ?>
                                <div class="public-card-placeholder">
                                    <?= icon('plante', 40, 'placeholder-icon') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="public-card-body">
                            <h3><?= htmlspecialchars($p['nom']) ?></h3>
                            <?php if ($p['nom_latin']): ?>
                                <em><?= htmlspecialchars($p['nom_latin']) ?></em>
                            <?php endif; ?>
                            <?php if (!empty($cats)): ?>
                                <div class="card-cats">
                                    <?php foreach ($cats as $cat): ?>
                                        <span class="card-cat-tag"><?= htmlspecialchars($cat['nom']) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <p id="search-empty" style="display:none; text-align:center; color:var(--texte-light); padding:2rem;">
            Aucune plante ne correspond à votre recherche.
        </p>
    </section>

    <section id="composants" class="public-section">
        <h2 class="section-title">
            <?= icon('composant', 20, 'section-icon composant') ?> Composants
            <span><?= count(array_filter($composants, fn($c) => $c['actif'])) ?></span>
        </h2>
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

    <section id="vertus" class="public-section">
        <h2 class="section-title">
            <?= icon('vertu', 20, 'section-icon vertu') ?> Vertus
            <span><?= count(array_filter($vertus, fn($v) => $v['actif'])) ?></span>
        </h2>
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

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
