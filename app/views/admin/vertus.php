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
            <h2>✨ Vertus</h2>
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
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($vertus)): ?>
                    <tr>
                        <td colspan="4" style="text-align:center; color:var(--texte-light); padding:2rem;">
                            Aucune vertu — <a href="<?= APP_URL ?>/admin/vertus/creer">Ajouter la première</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($vertus as $v): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($v['nom']) ?></strong></td>
                        <td><em style="color:var(--texte-light)"><?= htmlspecialchars($v['categorie'] ?? '') ?></em></td>
                        <td>
                            <span class="badge <?= $v['actif'] ? 'badge-actif' : 'badge-inactif' ?>">
                                <?= $v['actif'] ? 'Publié' : 'Masqué' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= APP_URL ?>/admin/vertus/<?= $v['id'] ?>/editer"
                               class="btn btn-sm btn-secondary">✏️ Éditer</a>
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
