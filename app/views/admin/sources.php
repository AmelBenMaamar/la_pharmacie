<?php require_once APP_ROOT . '/app/views/layouts/icons.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sources bibliographiques — La Pharmacie</title>
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
                <h2>Sources bibliographiques</h2>
                <p style="color:var(--texte-light);font-size:0.85rem;margin-top:0.25rem;">
                    <?= count($sources) ?> source<?= count($sources) > 1 ? 's' : '' ?> enregistrée<?= count($sources) > 1 ? 's' : '' ?>
                </p>
            </div>
            <a href="<?= APP_URL ?>/admin/sources/creer" class="btn btn-primary btn-sm">+ Nouvelle source</a>
        </div>

        <?php foreach (['success', 'error'] as $_ft): ?>
            <?php if (!empty($_SESSION['flash'][$_ft])): ?>
                <div class="alert alert-<?= $_ft ?>">
                    <?= htmlspecialchars($_SESSION['flash'][$_ft]) ?>
                </div>
                <?php unset($_SESSION['flash'][$_ft]); ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Journal / Année</th>
                        <th>Composants</th>
                        <th>Vertus</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($sources)): ?>
                    <tr><td colspan="6" style="text-align:center;color:var(--texte-light);padding:2rem;">Aucune source pour l'instant</td></tr>
                <?php endif; ?>
                <?php foreach ($sources as $s): ?>
                    <tr>
                        <td>
                            <div style="font-weight:500;font-size:0.9rem;"><?= htmlspecialchars($s['titre']) ?></div>
                            <?php if (!empty($s['auteurs'])): ?>
                                <div style="font-size:0.78rem;color:var(--texte-light);margin-top:0.15rem;"><?= htmlspecialchars($s['auteurs']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge-source badge-source-<?= $s['type_source'] ?>"><?= htmlspecialchars($s['type_source']) ?></span></td>
                        <td>
                            <?php if (!empty($s['journal'])): ?>
                                <em style="font-size:0.85rem;"><?= htmlspecialchars($s['journal']) ?></em><br>
                            <?php endif; ?>
                            <?php if (!empty($s['annee'])): ?>
                                <span style="font-size:0.8rem;color:var(--texte-light);"><?= $s['annee'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:center;">
                            <span class="badge" style="background:rgba(107,148,214,0.12);color:#2a4a8f;"><?= $s['nb_composants'] ?></span>
                        </td>
                        <td style="text-align:center;">
                            <span class="badge" style="background:rgba(218,247,218,0.6);color:#2a6a3a;"><?= $s['nb_vertus'] ?></span>
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="<?= APP_URL ?>/admin/sources/<?= $s['id'] ?>/liens"
                                   class="btn btn-secondary btn-sm" title="Lier composants / vertus">⇌ Liens</a>
                                <a href="<?= APP_URL ?>/admin/sources/<?= $s['id'] ?>/editer"
                                   class="btn btn-secondary btn-sm">Éditer</a>
                                <form method="POST" action="<?= APP_URL ?>/admin/sources/<?= $s['id'] ?>/supprimer"
                                      onsubmit="return confirm('Supprimer cette source ?')">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                    <button class="btn btn-danger btn-sm">Suppr.</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </main>
</div>
</body>
</html>
