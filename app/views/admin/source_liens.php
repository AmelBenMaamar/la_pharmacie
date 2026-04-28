<?php require_once APP_ROOT . '/app/views/layouts/icons.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liens — <?= htmlspecialchars($source['titre']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
<div class="admin-layout">
    <?php include __DIR__ . '/../layouts/sidebar.php'; ?>
    <main class="admin-main">

        <div class="page-header">
            <div>
                <h2>Liens — Source</h2>
                <p style="font-size:0.85rem;color:var(--texte-light);margin-top:0.25rem;max-width:600px;">
                    <?= htmlspecialchars($source['titre']) ?>
                    <?php if (!empty($source['annee'])): ?>
                        <span style="color:var(--brun-light);">(<?= $source['annee'] ?>)</span>
                    <?php endif; ?>
                </p>
            </div>
            <div style="display:flex;gap:0.5rem;">
                <a href="<?= APP_URL ?>/admin/sources/<?= $source['id'] ?>/editer"
                   class="btn btn-secondary btn-sm">Éditer</a>
                <a href="<?= APP_URL ?>/admin/sources" class="btn btn-secondary btn-sm">← Retour</a>
            </div>
        </div>

        <?php foreach (['success', 'error'] as $_ft): ?>
            <?php if (!empty($_SESSION['flash'][$_ft])): ?>
                <div class="alert alert-<?= $_ft ?>">
                    <?= htmlspecialchars($_SESSION['flash'][$_ft]) ?>
                </div>
                <?php unset($_SESSION['flash'][$_ft]); ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">

            <!-- COMPOSANTS -->
            <div class="liens-section">
                <h3><?= icon('composant', 16, 'section-icon composant') ?> Composants liés
                    <span style="font-size:0.78rem;color:var(--texte-light);font-weight:400;">
                        (<?= count($composants_lies) ?>)
                    </span>
                </h3>

                <?php if (!empty($composants_lies)): ?>
                    <div class="liens-list">
                        <?php foreach ($composants_lies as $c): ?>
                            <div class="lien-item">
                                <span class="tag tag-composant"><?= htmlspecialchars($c['nom']) ?></span>
                                <form method="POST"
                                      action="<?= APP_URL ?>/admin/sources/<?= $source['id'] ?>/liens/supprimer">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token) ?>">
                                    <input type="hidden" name="type" value="composant">
                                    <input type="hidden" name="composant_id" value="<?= $c['id'] ?>">
                                    <button class="lien-remove" title="Retirer">✕</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="font-size:0.85rem;color:var(--texte-light);margin-bottom:1rem;">
                        Aucun composant lié.
                    </p>
                <?php endif; ?>

                <form method="POST" action="<?= APP_URL ?>/admin/sources/<?= $source['id'] ?>/liens">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token) ?>">
                    <input type="hidden" name="type" value="composant">
                    <div style="display:flex;gap:0.5rem;align-items:center;flex-wrap:wrap;">
                        <select name="composant_id" style="flex:1;min-width:0;padding:0.5rem 0.75rem;border:1.5px solid var(--border);border-radius:var(--radius);background:var(--creme);font-size:0.88rem;">
                            <?php foreach ($all_composants as $c): ?>
                                <?php $deja = in_array($c['id'], array_column($composants_lies, 'id')); ?>
                                <option value="<?= $c['id'] ?>" <?= $deja ? 'disabled style="color:var(--texte-light)"' : '' ?>>
                                    <?= htmlspecialchars($c['nom']) ?><?= $deja ? ' ✓' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-secondary btn-sm">+ Lier</button>
                    </div>
                </form>
            </div>

            <!-- VERTUS -->
            <div class="liens-section">
                <h3><?= icon('vertu', 16, 'section-icon vertu') ?> Vertus liées
                    <span style="font-size:0.78rem;color:var(--texte-light);font-weight:400;">
                        (<?= count($vertus_liees) ?>)
                    </span>
                </h3>

                <?php if (!empty($vertus_liees)): ?>
                    <div class="liens-list">
                        <?php foreach ($vertus_liees as $v): ?>
                            <div class="lien-item">
                                <span class="tag tag-vertu"><?= htmlspecialchars($v['nom']) ?></span>
                                <form method="POST"
                                      action="<?= APP_URL ?>/admin/sources/<?= $source['id'] ?>/liens/supprimer">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token) ?>">
                                    <input type="hidden" name="type" value="vertu">
                                    <input type="hidden" name="vertu_id" value="<?= $v['id'] ?>">
                                    <button class="lien-remove" title="Retirer">✕</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="font-size:0.85rem;color:var(--texte-light);margin-bottom:1rem;">
                        Aucune vertu liée.
                    </p>
                <?php endif; ?>

                <form method="POST" action="<?= APP_URL ?>/admin/sources/<?= $source['id'] ?>/liens">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token) ?>">
                    <input type="hidden" name="type" value="vertu">
                    <div style="display:flex;gap:0.5rem;align-items:center;flex-wrap:wrap;">
                        <select name="vertu_id" style="flex:1;min-width:0;padding:0.5rem 0.75rem;border:1.5px solid var(--border);border-radius:var(--radius);background:var(--creme);font-size:0.88rem;">
                            <?php foreach ($all_vertus as $v): ?>
                                <?php $deja = in_array($v['id'], array_column($vertus_liees, 'id')); ?>
                                <option value="<?= $v['id'] ?>" <?= $deja ? 'disabled style="color:var(--texte-light)"' : '' ?>>
                                    <?= htmlspecialchars($v['nom']) ?><?= $deja ? ' ✓' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-secondary btn-sm">+ Lier</button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Aperçu public -->
        <div style="margin-top:1.5rem;padding:1rem 1.25rem;background:var(--creme-dark);border-radius:var(--radius);font-size:0.82rem;color:var(--texte-light);">
            Aperçu public :
            <a href="<?= APP_URL ?>/sources/<?= $source['id'] ?>" target="_blank"
               style="color:var(--turquoise);">
                <?= APP_URL ?>/sources/<?= $source['id'] ?> →
            </a>
        </div>

    </main>
</div>
</body>
</html>
