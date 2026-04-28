<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<div class="fiche-header" style="padding:2.5rem 2rem 2rem;">
    <div style="max-width:900px;margin:0 auto;">
        <h1 class="fiche-title" style="margin-bottom:0.5rem;">Sources & Études</h1>
        <p style="color:var(--texte-light);line-height:1.7;max-width:600px;">
            Références scientifiques et bibliographiques qui fondent les informations présentées
            sur les plantes, composants actifs et vertus thérapeutiques.
        </p>
    </div>
</div>

<div class="fiche-body">

    <?php if (empty($sources)): ?>
        <p style="color:var(--texte-light);text-align:center;padding:3rem 0;">
            Aucune source publiée pour l'instant.
        </p>
    <?php else: ?>

        <?php
        // Libellés affichables par type
        $labels = [
            'etude'          => 'Étude',
            'meta-analyse'   => 'Méta-analyse',
            'revue'          => 'Revue systématique',
            'essai-clinique' => 'Essai clinique',
            'rapport'        => 'Rapport',
            'autre'          => 'Autre',
        ];
        ?>

        <?php foreach ($parType as $type => $groupe): ?>
        <div class="fiche-section">
            <h3 style="display:flex;align-items:center;gap:0.75rem;">
                <?= htmlspecialchars($labels[$type] ?? ucfirst($type)) ?>
                <span style="font-size:0.78rem;font-family:var(--font-sans);font-weight:400;color:var(--texte-light);">
                    <?= count($groupe) ?>
                </span>
            </h3>

            <div style="display:flex;flex-direction:column;gap:1rem;">
                <?php foreach ($groupe as $s): ?>
                    <a href="<?= APP_URL ?>/sources/<?= $s['id'] ?>"
                       style="text-decoration:none;display:block;padding:1rem 1.25rem;border:1.5px solid var(--border);border-radius:var(--radius);background:var(--creme);transition:border-color 0.2s,box-shadow 0.2s;"
                       class="source-card">
                        <div style="font-family:var(--font-serif);font-size:1rem;color:var(--brun-dark);margin-bottom:0.3rem;line-height:1.4;">
                            <?= htmlspecialchars($s['titre']) ?>
                        </div>
                        <div style="font-size:0.8rem;color:var(--texte-light);display:flex;gap:1rem;flex-wrap:wrap;align-items:center;">
                            <?php if (!empty($s['auteurs'])): ?>
                                <span><?= htmlspecialchars($s['auteurs']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($s['journal'])): ?>
                                <em><?= htmlspecialchars($s['journal']) ?></em>
                            <?php endif; ?>
                            <?php if (!empty($s['annee'])): ?>
                                <span style="font-weight:500;color:var(--brun);"><?= $s['annee'] ?></span>
                            <?php endif; ?>
                            <?php if (!empty($s['doi'])): ?>
                                <span style="font-family:monospace;font-size:0.75rem;opacity:0.7;">
                                    DOI: <?= htmlspecialchars($s['doi']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>

    <?php endif; ?>

    <p style="margin-top:1rem;">
        <a href="<?= APP_URL ?>/" class="btn btn-secondary btn-sm">← Retour à l'accueil</a>
    </p>

</div>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
