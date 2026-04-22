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
            <h2>🌿 Plantes</h2>
            <a href="<?= APP_URL ?>/admin/plantes/creer" class="btn btn-primary">
                + Ajouter une plante
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Nom latin</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($plantes)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color: var(--texte-light); padding: 2rem;">
                            Aucune plante pour l'instant — <a href="<?= APP_URL ?>/admin/plantes/creer">Ajouter la première</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($plantes as $plante): ?>
                    <tr>
                        <td>
                            <?php if ($plante['image']): ?>
                                <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($plante['image']) ?>"
                                     alt="<?= htmlspecialchars($plante['nom']) ?>"
                                     style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                            <?php else: ?>
                                <div style="width:50px;height:50px;background:var(--creme-dark);border-radius:8px;display:flex;align-items:center;justify-content:center;">🌿</div>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= htmlspecialchars($plante['nom']) ?></strong></td>
                        <td><em style="color:var(--texte-light)"><?= htmlspecialchars($plante['nom_latin'] ?? '') ?></em></td>
                        <td>
                            <span class="badge <?= $plante['actif'] ? 'badge-actif' : 'badge-inactif' ?>">
                                <?= $plante['actif'] ? 'Publié' : 'Masqué' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens"
                               class="btn btn-sm btn-primary">🔗 Liens</a>
                            <a href="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/editer"
                               class="btn btn-sm btn-secondary">✏️ Éditer</a>
                            <form method="POST"
                                  action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/supprimer"
                                  style="display:inline;"
                                  onsubmit="return confirm('Supprimer cette plante ?')">
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
