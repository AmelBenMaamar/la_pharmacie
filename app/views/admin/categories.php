<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories — La Pharmacie</title>
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
            <h2>📂 Catégories</h2>
            <a href="<?= APP_URL ?>/admin/categories/creer" class="btn btn-primary">
                + Ajouter une catégorie
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Couleur</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="4" style="text-align:center; color:var(--texte-light); padding:2rem;">
                            Aucune catégorie — <a href="<?= APP_URL ?>/admin/categories/creer">Ajouter la première</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td>
                            <div style="width:32px;height:32px;border-radius:50%;background:<?= htmlspecialchars($cat['couleur']) ?>;border:2px solid rgba(0,0,0,0.1);"></div>
                        </td>
                        <td>
                            <span class="tag" style="background:<?= htmlspecialchars($cat['couleur']) ?>22;border-color:<?= htmlspecialchars($cat['couleur']) ?>44;color:<?= htmlspecialchars($cat['couleur']) ?>">
                                <?= htmlspecialchars($cat['nom']) ?>
                            </span>
                        </td>
                        <td style="color:var(--texte-light); font-size:0.88rem;">
                            <?= htmlspecialchars($cat['description'] ?? '') ?>
                        </td>
                        <td>
                            <a href="<?= APP_URL ?>/admin/categories/<?= $cat['id'] ?>/editer"
                               class="btn btn-sm btn-secondary">✏️ Éditer</a>
                            <form method="POST"
                                  action="<?= APP_URL ?>/admin/categories/<?= $cat['id'] ?>/supprimer"
                                  style="display:inline;"
                                  onsubmit="return confirm('Supprimer cette catégorie ?')">
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
