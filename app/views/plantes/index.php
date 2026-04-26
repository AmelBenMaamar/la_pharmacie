<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<div class="fiche-header">
    <div class="fiche-header-inner" style="grid-template-columns:1fr; max-width:900px;">
        <div>
            <h1 class="fiche-title">Plantes</h1>
            <p class="fiche-latin">Toutes les plantes du catalogue</p>
        </div>
    </div>
</div>

<div class="fiche-body">
    <div class="fiche-section">
        <?php if (empty($plantes)): ?>
            <p style="color:var(--texte-light); text-align:center; padding:2rem;">
                Aucune plante disponible pour l'instant.
            </p>
        <?php else: ?>
            <div class="cards-grid">
                <?php foreach ($plantes as $p): ?>
                    <a href="<?= APP_URL ?>/plantes/<?= htmlspecialchars($p['slug']) ?>"
                       class="public-card">
                        <div class="public-card-img">
                            <?php if (!empty($p['image'])): ?>
                                <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($p['image']) ?>"
                                     alt="<?= htmlspecialchars($p['nom']) ?>">
                            <?php else: ?>
                                <div class="public-card-placeholder">
                                    <?= icon('plante', 48, 'placeholder-icon') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="public-card-body">
                            <h3><?= htmlspecialchars($p['nom']) ?></h3>
                            <?php if (!empty($p['nom_latin'])): ?>
                                <em><?= htmlspecialchars($p['nom_latin']) ?></em>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
