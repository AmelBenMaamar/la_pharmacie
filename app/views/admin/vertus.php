<?php require_once __DIR__ . '/../layouts/icons.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vertus — La Pharmacie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
<div class="admin-layout">

    <?php include __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="admin-main">

        <?php $flash = $_SESSION['flash']['success'] ?? null; unset($_SESSION['flash']['success']); ?>
        <?php if ($flash): ?>
            <div class="alert alert-success"><?= htmlspecialchars($flash) ?></div>
        <?php endif; ?>

        <div class="page-header">
            <h2><?= icon('vertu', 22, 'section-icon vertu') ?> Vertus</h2>
            <a href="<?= APP_URL ?>/admin/vertus/creer" class="btn btn-primary">
                + Ajouter une vertu
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th style="text-align:center;">Composants</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($vertus)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:var(--texte-light); padding:2rem;">
                            Aucune vertu — <a href="<?= APP_URL ?>/admin/vertus/creer">Ajouter la première</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($vertus as $v): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($v['nom']) ?></strong></td>
                        <td><em style="color:var(--texte-light)"><?= htmlspecialchars($v['categorie'] ?? '') ?></em></td>
                        <td style="text-align:center;">
                            <a href="<?= APP_URL ?>/admin/vertus/<?= $v['id'] ?>/composants"
                               title="Gérer les composants"
                               style="display:inline-flex; align-items:center; gap:0.3rem; text-decoration:none;">
                                <span class="badge <?= ($v['nb_composants'] ?? 0) > 0 ? 'badge-actif' : 'badge-inactif' ?>">
                                    <?= (int)($v['nb_composants'] ?? 0) ?> composant<?= ($v['nb_composants'] ?? 0) > 1 ? 's' : '' ?>
                                </span>
                            </a>
                        </td>
                        <td>
                            <span class="badge <?= $v['actif'] ? 'badge-actif' : 'badge-inactif' ?>">
                                <?= $v['actif'] ? 'Publié' : 'Masqué' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= APP_URL ?>/admin/vertus/<?= $v['id'] ?>/composants"
                               class="btn btn-sm btn-secondary"
                               title="Lier des composants">
                                <?= icon('lien', 14) ?> Composants
                            </a>
                            <a href="<?= APP_URL ?>/admin/vertus/<?= $v['id'] ?>/editer"
                               class="btn btn-sm btn-secondary"><?= icon('edit', 14) ?> Éditer</a>
                            <form method="POST"
                                  action="<?= APP_URL ?>/admin/vertus/<?= $v['id'] ?>/supprimer"
                                  style="display:inline;"
                                  onsubmit="return confirm('Supprimer cette vertu ?')">
                                <input type="hidden" name="csrf_token" value="<?= $this->csrfToken() ?>">
                                <button class="btn btn-sm btn-danger">🗑</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>
</div>
</body>
</html>
