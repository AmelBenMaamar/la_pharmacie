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
                <p style="line-height:1.7; margin-top:0.75rem;">
                    <?= nl2br(htmlspecialchars($vertu['description'])) ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="fiche-body">

<?php if (!empty($composants)): ?>
<div class="fiche-section">
    <h3><?= icon('composant', 18, 'section-icon composant') ?>
        Composants actifs → Plantes
        <span style="font-size:0.8rem;color:var(--texte-light);font-family:var(--font-sans);font-weight:400;">
            <?= count($composants) ?> composants
        </span>
    </h3>

    <div class="flux-composants">
    <?php foreach ($composants as $c):
        $evidence = $c['niveau_evidence'] ?? '';
        $evidenceClass = match($evidence) {
            'fort'   => 'evidence-fort',
            'modere' => 'evidence-modere',
            default  => 'evidence-default',
        };
        $evidenceLabel = match($evidence) {
            'fort'   => '★★★ Fort',
            'modere' => '★★☆ Modéré',
            default  => '★☆☆ Faible',
        };
    ?>
    <div class="flux-composant-bloc">

        <!-- Composant -->
        <a href="<?= APP_URL ?>/composants/<?= htmlspecialchars($c['slug']) ?>"
           class="flux-composant-header">
            <div class="flux-composant-left">
                <span class="flux-composant-icon"><?= icon('composant', 20, '') ?></span>
                <div>
                    <strong class="flux-composant-nom"><?= htmlspecialchars($c['nom']) ?></strong>
                    <?php if (!empty($c['famille'])): ?>
                        <small class="flux-composant-famille"><?= htmlspecialchars($c['famille']) ?></small>
                    <?php endif; ?>
                </div>
            </div>
            <span class="flux-evidence-badge <?= $evidenceClass ?>">
                <?= $evidenceLabel ?>
            </span>
        </a>

        <?php if (!empty($c['notes'])): ?>
            <p class="flux-composant-notes"><?= htmlspecialchars($c['notes']) ?></p>
        <?php endif; ?>

        <!-- Plantes associées à ce composant -->
        <?php if (!empty($c['plantes'])): ?>
        <div class="flux-plantes-row">
            <span class="flux-arrow">↳</span>
            <div class="flux-plantes-chips">
                <?php foreach ($c['plantes'] as $p): ?>
                <a href="<?= APP_URL ?>/plantes/<?= htmlspecialchars($p['slug']) ?>"
                   class="flux-plante-chip">
                    <?php if (!empty($p['image'])): ?>
                        <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($p['image']) ?>"
                             alt="<?= htmlspecialchars($p['nom']) ?>"
                             class="flux-plante-chip-img">
                    <?php else: ?>
                        <span class="flux-plante-chip-placeholder"><?= icon('plante', 14, '') ?></span>
                    <?php endif; ?>
                    <span><?= htmlspecialchars($p['nom']) ?></span>
                    <?php if (!empty($p['concentration'])): ?>
                        <small class="flux-concentration"><?= htmlspecialchars($p['concentration']) ?></small>
                    <?php endif; ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
    <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

    <p style="margin-top:2rem;">
        <a href="<?= APP_URL ?>/vertus" class="btn-retour-vertus">← Toutes les vertus</a>
    </p>

</div>

<?php require APP_ROOT . '/app/views/layouts/_sources_widget.php'; ?>
<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
