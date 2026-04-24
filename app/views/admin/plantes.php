<?php require_once APP_ROOT . '/app/views/layouts/icons.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plantes — La Pharmacie</title>
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
            <div>
                <h2><?= icon('plante', 22, 'section-icon plante') ?> Plantes</h2>
                <p style="color:var(--texte-light);font-size:0.85rem;margin-top:0.25rem;">
                    <?= count($plantes) ?> plante<?= count($plantes) > 1 ? 's' : '' ?> au total
                </p>
            </div>
            <a href="<?= APP_URL ?>/admin/plantes/creer" class="btn btn-primary">
                + Ajouter une plante
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width:70px">Image</th>
                        <th>Nom</th>
                        <th>Nom latin</th>
                        <th style="width:100px">Statut</th>
                        <th style="width:200px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($plantes)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:var(--texte-light); padding:3rem;">
                            <?= icon('plante', 32, 'placeholder-icon') ?>
                            <p style="margin-top:0.75rem;">Aucune plante —
                                <a href="<?= APP_URL ?>/admin/plantes/creer">Ajouter la première</a>
                            </p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($plantes as $plante): ?>
                    <tr>
                        <td>
                            <?php if ($plante['image']): ?>
                                <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($plante['image']) ?>"
                                     alt="<?= htmlspecialchars($plante['nom']) ?>"
                                     class="table-thumb">
                            <?php else: ?>
                                <div class="table-thumb-placeholder">
                                    <?= icon('plante', 20, 'placeholder-icon') ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= htmlspecialchars($plante['nom']) ?></strong></td>
                        <td><em style="color:var(--texte-light); font-size:0.85rem"><?= htmlspecialchars($plante['nom_latin'] ?? '') ?></em></td>
                        <td>
                            <span class="badge <?= $plante['actif'] ? 'badge-actif' : 'badge-inactif' ?>">
                                <?= $plante['actif'] ? 'Publié' : 'Masqué' ?>
                            </span>
                        </td>
                        <td class="table-actions">
                            <a href="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens"
                               class="btn btn-sm btn-primary">Liens</a>
                            <a href="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/editer"
                               class="btn btn-sm btn-secondary">Éditer</a>
                            <form method="POST"
                                  action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/supprimer"
                                  style="display:inline;"
                                  onsubmit="return confirm('Supprimer cette plante ?')">
                                <input type="hidden" name="csrf_token" value="<?= $this->csrfToken() ?>">
                                <button class="btn btn-sm btn-danger" title="Supprimer">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                                        <path d="M10 11v6M14 11v6M9 6V4h6v2"/>
                                    </svg>
                                </button>
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
