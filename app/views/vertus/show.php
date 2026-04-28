<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<div class="fiche-header">
    <div class="fiche-header-inner">

        <div class="fiche-img-placeholder"><?= icon('vertu', 64, 'placeholder-icon') ?></div>

        <div>
            <?php if (!empty($vertu['categorie'])): ?>
                <span class="tag tag-vertu" style="margin-bottom:0.75rem; display:inline-flex;">
                    <?= htmlspecialchars($vertu['categorie']) ?>
                </span>
            <?php endif; ?>

            <h1 class="fiche-title"><?= htmlspecialchars($vertu['nom']) ?></h1>

            <?php if (!empty($vertu['description'])): ?>
                <p style="color:var(--texte-light); line-height:1.7; margin-top:0.75rem;">
                    <?= nl2br(htmlspecialchars($vertu['description'])) ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="fiche-body">

    <?php if (!empty($plantes)): ?>
    <div class="fiche-section">
        <h3><?= icon('plante', 18, 'section-icon plante') ?> Plantes avec cette vertu <span style="font-size:0.8rem;color:var(--texte-light);font-family:var(--font-sans);font-weight:400;"><?= count($plantes) ?></span></h3>
        <div class="cards-grid">
            <?php foreach ($plantes as $p): ?>
                <a href="<?= APP_URL ?>/plantes/<?= htmlspecialchars($p['slug']) ?>" class="public-card">
                    <div class="public-card-img">
                        <?php if (!empty($p['image'])): ?>
                            <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($p['image']) ?>"
                                 alt="<?= htmlspecialchars($p['nom']) ?>">
                        <?php else: ?>
                            <div class="public-card-placeholder"><?= icon('plante', 40, 'placeholder-icon') ?></div>
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
    </div>
    <?php endif; ?>

    <?php if (!empty($composants)): ?>
    <div class="fiche-section">
        <h3><?= icon('composant', 18, 'section-icon composant') ?> Composants actifs impliqués <span style="font-size:0.8rem;color:var(--texte-light);font-family:var(--font-sans);font-weight:400;"><?= count($composants) ?></span></h3>
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
    </div>
    <?php endif; ?>

    <p style="margin-top:1rem;">
        <a href="<?= APP_URL ?>/" class="btn btn-secondary btn-sm">← Retour à l'accueil</a>
    </p>

</div>

<?php require APP_ROOT . '/app/views/layouts/_sources_widget.php'; ?>
<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
