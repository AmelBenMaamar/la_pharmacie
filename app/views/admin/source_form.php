<?php require_once APP_ROOT . '/app/views/layouts/icons.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $source ? 'Éditer' : 'Nouvelle' ?> source — La Pharmacie</title>
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
                <h2><?= $source ? 'Éditer la source' : 'Nouvelle source' ?></h2>
            </div>
            <a href="<?= APP_URL ?>/admin/sources" class="btn btn-secondary btn-sm">← Retour</a>
        </div>

        <?php
        $action = $source
            ? APP_URL . '/admin/sources/' . $source['id'] . '/editer'
            : APP_URL . '/admin/sources/creer';
        $v = $source ?? [];
        ?>

        <form method="POST" action="<?= $action ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token) ?>">

            <div class="admin-form">

                <div class="form-group">
                    <label>Titre de la publication *</label>
                    <input type="text" name="titre" required
                           value="<?= htmlspecialchars($v['titre'] ?? '') ?>"
                           placeholder="Ex : Effet anti-inflammatoire du curcuma sur NF-κB…">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Auteurs</label>
                        <input type="text" name="auteurs"
                               value="<?= htmlspecialchars($v['auteurs'] ?? '') ?>"
                               placeholder="Smith J., Dupont A., etc.">
                    </div>
                    <div class="form-group">
                        <label>Type de source</label>
                        <select name="type_source">
                            <?php foreach (['etude','meta-analyse','revue','essai-clinique','rapport','autre'] as $t): ?>
                                <option value="<?= $t ?>" <?= ($v['type_source'] ?? 'etude') === $t ? 'selected' : '' ?>>
                                    <?= ucfirst($t) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Journal / Revue</label>
                        <input type="text" name="journal"
                               value="<?= htmlspecialchars($v['journal'] ?? '') ?>"
                               placeholder="Nature Communications, PubMed…">
                    </div>
                    <div class="form-group">
                        <label>Année de publication</label>
                        <input type="number" name="annee" min="1900" max="<?= date('Y') ?>"
                               value="<?= htmlspecialchars($v['annee'] ?? '') ?>"
                               placeholder="<?= date('Y') ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>URL (lien article)</label>
                        <input type="url" name="url"
                               value="<?= htmlspecialchars($v['url'] ?? '') ?>"
                               placeholder="https://pubmed.ncbi.nlm.nih.gov/…">
                    </div>
                    <div class="form-group">
                        <label>DOI</label>
                        <input type="text" name="doi"
                               value="<?= htmlspecialchars($v['doi'] ?? '') ?>"
                               placeholder="10.1038/s41467-…">
                    </div>
                </div>

                <div class="form-group">
                    <label>Résumé / Notes</label>
                    <textarea name="resume" rows="5"
                              placeholder="Résumé des conclusions principales, pertinence pour la pharmacie…"><?= htmlspecialchars($v['resume'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="actif" value="1"
                               <?= ($v['actif'] ?? 1) ? 'checked' : '' ?>>
                        Source active (visible publiquement)
                    </label>
                </div>

                <div style="display:flex;gap:1rem;margin-top:1.5rem;">
                    <button type="submit" class="btn btn-primary">
                        <?= $source ? 'Enregistrer les modifications' : 'Créer la source' ?>
                    </button>
                    <?php if ($source): ?>
                        <a href="<?= APP_URL ?>/admin/sources/<?= $source['id'] ?>/liens"
                           class="btn btn-secondary">⇌ Gérer les liens</a>
                    <?php endif; ?>
                </div>

            </div>
        </form>

    </main>
</div>
</body>
</html>
