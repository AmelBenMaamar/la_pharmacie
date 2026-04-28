<?php
/**
 * LA PHARMACIE — Widget "Sources" réutilisable
 * 
 * À inclure dans plantes/show.php, composants/show.php, vertus/show.php
 * 
 * Variables attendues selon le contexte :
 *   $plante    → requête plante_source
 *   $composant → requête composant_source
 *   $vertu     → requête vertu_source
 */

// Récupère la connexion via le Singleton
$pdo = Database::getInstance();

// Détermine la table et l'id selon le contexte
if (!empty($plante)) {
    $pivotTable = 'plante_source';
    $fkCol      = 'plante_id';
    $entityId   = $plante['id'];
} elseif (!empty($composant)) {
    $pivotTable = 'composant_source';
    $fkCol      = 'composant_id';
    $entityId   = $composant['id'];
} elseif (!empty($vertu)) {
    $pivotTable = 'vertu_source';
    $fkCol      = 'vertu_id';
    $entityId   = $vertu['id'];
} else {
    return; // pas de contexte, on n'affiche rien
}

// Récupère les sources liées
$stmtSrc = $pdo->prepare("
    SELECT s.id, s.titre, s.auteurs, s.type_source, s.journal, s.annee, s.url, s.doi, s.`resume`
    FROM sources s
    JOIN `$pivotTable` ps ON ps.source_id = s.id
    WHERE ps.`$fkCol` = ?
      AND s.actif = 1
    ORDER BY s.annee DESC, s.titre
");
$stmtSrc->execute([$entityId]);
$sources = $stmtSrc->fetchAll(PDO::FETCH_ASSOC);

if (empty($sources)) return;
?>

<section class="sources-section">
  <h2 class="sources-title">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
      <path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/>
    </svg>
    Sources scientifiques
  </h2>

  <ul class="sources-list">
    <?php foreach ($sources as $s): ?>
    <li class="source-item">
      <details class="source-details">
        <summary class="source-summary">

          <div class="source-summary-main">
            <div class="source-header">
              <?php if ($s['type_source']): ?>
                <span class="source-type"><?= htmlspecialchars($s['type_source']) ?></span>
              <?php endif ?>
              <?php if ($s['annee']): ?>
                <span class="source-year"><?= (int)$s['annee'] ?></span>
              <?php endif ?>
            </div>
            <p class="source-titre"><?= htmlspecialchars($s['titre']) ?></p>
            <?php if ($s['auteurs'] || $s['journal']): ?>
            <p class="source-meta">
              <?php if ($s['auteurs']): ?>
                <span class="source-auteurs"><?= htmlspecialchars($s['auteurs']) ?></span>
              <?php endif ?>
              <?php if ($s['journal']): ?>
                <em class="source-journal"> — <?= htmlspecialchars($s['journal']) ?></em>
              <?php endif ?>
            </p>
            <?php endif ?>
          </div>

          <svg class="source-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <polyline points="6 9 12 15 18 9"/>
          </svg>

        </summary>

        <div class="source-body">

          <?php if (!empty($s['resume'])): ?>
          <p class="source-resume"><?= nl2br(htmlspecialchars($s['resume'])) ?></p>
          <?php endif ?>

          <div class="source-links">
            <?php if ($s['url']): ?>
            <a href="<?= htmlspecialchars($s['url']) ?>" target="_blank" rel="noopener noreferrer" class="source-link">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/>
              </svg>
              Consulter la source
            </a>
            <?php endif ?>
            <?php if ($s['doi']): ?>
            <a href="https://doi.org/<?= htmlspecialchars($s['doi']) ?>" target="_blank" rel="noopener noreferrer" class="source-link source-link-doi">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
              </svg>
              DOI : <?= htmlspecialchars($s['doi']) ?>
            </a>
            <?php endif ?>
          </div>

        </div>
      </details>
    </li>
    <?php endforeach ?>
  </ul>
</section>
