<?php
// Conversion Markdown basique pour l'affichage
function renderMarkdown(string $text): string {
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    // Titres
    $text = preg_replace('/^### (.+)$/m', '<h4>$1</h4>', $text);
    $text = preg_replace('/^## (.+)$/m',  '<h3>$1</h3>', $text);
    $text = preg_replace('/^# (.+)$/m',   '<h2>$1</h2>', $text);
    // Gras et italique
    $text = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text);
    $text = preg_replace('/\*(.+?)\*/s',     '<em>$1</em>', $text);
    // Listes
    $text = preg_replace('/^\* (.+)$/m',  '<li>$1</li>', $text);
    $text = preg_replace('/^> (.+)$/m',   '<blockquote>$1</blockquote>', $text);
    // Séparateurs
    $text = preg_replace('/^---$/m', '<hr>', $text);
    // Sauts de ligne (hors balises bloc)
    $text = preg_replace('/\n{2,}/', '</p><p>', $text);
    $text = '<p>' . $text . '</p>';
    // Nettoyer les <p> autour des balises bloc
    $text = preg_replace('/<p>(<h[2-4]>.*?<\/h[2-4]>)<\/p>/s', '$1', $text);
    $text = preg_replace('/<p>(<hr>)<\/p>/s', '$1', $text);
    return $text;
}
?>
<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<div class="fiche-header">
    <div class="fiche-header-inner">

        <?php if (!empty($plante['image'])): ?>
            <img src="<?= APP_URL ?>/uploads/plantes/<?= htmlspecialchars($plante['image']) ?>"
                 alt="<?= htmlspecialchars($plante['nom']) ?>"
                 class="fiche-img">
        <?php else: ?>
            <div class="fiche-img-placeholder">🌿</div>
        <?php endif; ?>

        <div>
            <?php if (!empty($categories)): ?>
                <div style="display:flex; flex-wrap:wrap; gap:0.4rem; margin-bottom:0.75rem;">
                    <?php foreach ($categories as $cat): ?>
                        <span class="tag tag-plante"><?= htmlspecialchars($cat['nom']) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <h1 class="fiche-title"><?= htmlspecialchars($plante['nom']) ?></h1>

            <?php if (!empty($plante['nom_latin'])): ?>
                <p class="fiche-latin"><?= htmlspecialchars($plante['nom_latin']) ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="fiche-body">

    <?php if (!empty($plante['description'])): ?>
    <div class="fiche-section">
        <div class="fiche-description">
            <?= renderMarkdown($plante['description']) ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($composants)): ?>
    <div class="fiche-section">
        <h3>🔬 Composants actifs <span style="font-size:0.8rem;color:var(--texte-light);font-family:var(--font-sans);font-weight:400;"><?= count($composants) ?></span></h3>
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
        <h3>✨ Vertus thérapeutiques <span style="font-size:0.8rem;color:var(--texte-light);font-family:var(--font-sans);font-weight:400;"><?= count($vertus) ?></span></h3>
        <div class="tags-cloud">
            <?php foreach ($vertus as $v): ?>
                <a href="<?= APP_URL ?>/vertus/<?= htmlspecialchars($v['slug']) ?>"
                   class="tag tag-vertu tag-lg">
                    <?= htmlspecialchars($v['nom']) ?>
                    <?php if (!empty($v['source'])): ?>
                        <small><?= htmlspecialchars($v['source']) ?></small>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (empty($composants) && empty($vertus)): ?>
    <div class="fiche-section" style="text-align:center; color:var(--texte-light); padding:3rem;">
        <p style="font-size:2rem; margin-bottom:0.5rem;">🌱</p>
        <p>Aucun lien renseigné pour cette plante pour l'instant.</p>
    </div>
    <?php endif; ?>

    <p style="margin-top:1rem;">
        <a href="<?= APP_URL ?>/" class="btn btn-secondary btn-sm">← Retour à l'accueil</a>
    </p>

</div>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
