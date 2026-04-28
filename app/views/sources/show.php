<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<div class="fiche-header">
    <div class="fiche-header-inner" style="grid-template-columns:1fr;">
        <div>
            <?php
            $labels = [
                'etude'          => 'Étude',
                'meta-analyse'   => 'Méta-analyse',
                'revue'          => 'Revue systématique',
                'essai-clinique' => 'Essai clinique',
                'rapport'        => 'Rapport',
                'autre'          => 'Autre',
            ];
            ?>
            <span class="tag tag-source" style="margin-bottom:0.75rem;display:inline-flex;">
                <?= htmlspecialchars($labels[$source['type_source']] ?? ucfirst($source['type_source'])) ?>
            </span>

            <h1 class="fiche-title" style="font-size:1.6rem;line-height:1.3;">
                <?= htmlspecialchars($source['titre']) ?>
            </h1>

            <div style="display:flex;flex-wrap:wrap;gap:1.25rem;margin-top:0.75rem;font-size:0.85rem;color:var(--texte-light);align-items:center;">
                <?php if (!empty($source['auteurs'])): ?>
                    <span>✍ <?= htmlspecialchars($source['auteurs']) ?></span>
                <?php endif; ?>
                <?php if (!empty($source['journal'])): ?>
                    <em><?= htmlspecialchars($source['journal']) ?></em>
                <?php endif; ?>
                <?php if (!empty($source['annee'])): ?>
                    <span style="font-weight:600;color:var(--brun);"><?= $source['annee'] ?></span>
                <?php endif; ?>
            </div>

            <?php if (!empty($source['doi']) || !empty($source['url'])): ?>
                <div style="margin-top:1rem;display:flex;gap:0.75rem;flex-wrap:wrap;">
                    <?php if (!empty($source['url'])): ?>
                        <a href="<?= htmlspecialchars($source['url']) ?>" target="_blank" rel="noopener"
                           class="btn btn-primary btn-sm">
                            Lire l'article →
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($source['doi'])): ?>
                        <a href="https://doi.org/<?= htmlspecialchars($source['doi']) ?>"
                           target="_blank" rel="noopener"
                           class="btn btn-secondary btn-sm">
                            DOI: <?= htmlspecialchars($source['doi']) ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="fiche-body">

    <?php if (!empty($source['resume'])): ?>
    <div class="fiche-section">
        <h3>Résumé</h3>
        <p style="color:var(--texte-light);line-height:1.75;">
            <?= nl2br(htmlspecialchars($source['resume'])) ?>
        </p>
    </div>
    <?php endif; ?>

    <?php if (!empty($composants)): ?>
    <div class="fiche-section">
        <h3>
            <?= icon('composant', 18, 'section-icon composant') ?>
            Composants documentés dans cette source
            <span style="font-size:0.8rem;color:var(--texte-light);font-family:var(--font-sans);font-weight:400;">
                <?= count($composants) ?>
            </span>
        </h3>
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

    <?php if (!empty($vertus)): ?>
    <div class="fiche-section">
        <h3>
            <?= icon('vertu', 18, 'section-icon vertu') ?>
            Vertus thérapeutiques appuyées par cette source
            <span style="font-size:0.8rem;color:var(--texte-light);font-family:var(--font-sans);font-weight:400;">
                <?= count($vertus) ?>
            </span>
        </h3>
        <div class="tags-cloud">
            <?php foreach ($vertus as $v): ?>
                <a href="<?= APP_URL ?>/vertus/<?= htmlspecialchars($v['slug']) ?>"
                   class="tag tag-vertu tag-lg">
                    <?= htmlspecialchars($v['nom']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <p style="margin-top:1rem;">
        <a href="<?= APP_URL ?>/sources" class="btn btn-secondary btn-sm">← Toutes les sources</a>
    </p>

</div>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
