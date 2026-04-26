<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<div class="fiche-header">
    <div class="fiche-header-inner" style="grid-template-columns:1fr; max-width:900px;">
        <div>
            <h1 class="fiche-title">Composants actifs</h1>
            <p class="fiche-latin">Tous les composants du catalogue</p>
        </div>
    </div>
</div>

<div class="fiche-body">
    <div class="fiche-section">
        <?php if (empty($composants)): ?>
            <p style="color:var(--texte-light); text-align:center; padding:2rem;">
                Aucun composant disponible pour l'instant.
            </p>
        <?php else: ?>
            <div class="tags-cloud">
                <?php foreach ($composants as $c): ?>
                    <a href="<?= APP_URL ?>/composants/<?= htmlspecialchars($c['slug']) ?>"
                       class="tag tag-composant tag-lg">
                        <?= htmlspecialchars($c['nom']) ?>
                        <?php if (!empty($c['famille'])): ?>
                            <small><?= htmlspecialchars($c['famille']) ?></small>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
