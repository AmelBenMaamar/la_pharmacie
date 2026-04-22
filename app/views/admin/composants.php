<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Composants — La Pharmacie</title>
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
            <h2>🔬 Composants</h2>
            <a href="<?= APP_URL ?>/admin/composants/creer" class="btn btn-primary">
                + Ajouter un composant
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Famille</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($composants)): ?>
                    <tr>
                        <td colspan="4" style="text-align:center; color:var(--texte-light); padding:2rem;">
                            Aucun composant — <a href="<?= APP_URL ?>/admin/composants/creer">Ajouter le premier</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($composants as $c): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($c['nom']) ?></strong></td>
                        <td><em style="color:var(--texte-light)"><?= htmlspecialchars($c['famille'] ?? '') ?></em></td>
                        <td>
                            <span class="badge <?= $c['actif'] ? 'badge-actif' : 'badge-inactif' ?>">
                                <?= $c['actif'] ? 'Publié' : 'Masqué' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= APP_URL ?>/admin/composants/<?= $c['id'] ?>/editer"
                               class="btn btn-sm btn-secondary">✏️ Éditer</a>
                            <form method="POST"
                                  action="<?= APP_URL ?>/admin/composants/<?= $c['id'] ?>/supprimer"
                                  style="display:inline;"
                                  onsubmit="return confirm('Supprimer ce composant ?')">
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
