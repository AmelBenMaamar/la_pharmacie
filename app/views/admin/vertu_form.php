<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $vertu ? 'Éditer' : 'Créer' ?> une vertu — La Pharmacie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
<div class="admin-layout">

    <?php include __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="admin-main">

        <div class="page-header">
            <h2><?= $vertu ? icon('edit', 16) . ' Éditer : ' . htmlspecialchars($vertu['nom']) : icon('vertu', 16) . ' Nouvelle vertu' ?></h2>
            <a href="<?= APP_URL ?>/admin/vertus" class="btn btn-secondary">← Retour</a>
        </div>

        <form class="admin-form"
              method="POST"
              action="<?= $vertu
                ? APP_URL . '/admin/vertus/' . $vertu['id'] . '/editer'
                : APP_URL . '/admin/vertus/creer' ?>">

            <input type="hidden" name="csrf_token" value="<?= $this->csrfToken() ?>">

            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom <span style="color:#c0392b">*</span></label>
                    <input type="text" id="nom" name="nom" required
                           placeholder="ex : Anti-inflammatoire"
                           value="<?= htmlspecialchars($vertu['nom'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="categorie">Catégorie</label>
                    <input type="text" id="categorie" name="categorie"
                           placeholder="ex : Immunité, Digestion, Sommeil..."
                           value="<?= htmlspecialchars($vertu['categorie'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5"
                          placeholder="Décrivez cette vertu, son mécanisme d'action..."><?= htmlspecialchars($vertu['description'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label for="actif">Statut</label>
                <select id="actif" name="actif">
                    <option value="1" <?= ($vertu['actif'] ?? 1) == 1 ? 'selected' : '' ?>>✅ Publié</option>
                    <option value="0" <?= ($vertu['actif'] ?? 1) == 0 ? 'selected' : '' ?>>🔒 Masqué</option>
                </select>
            </div>

            <div style="display:flex; gap:1rem; margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <?= $vertu ? icon('save', 16) . ' Enregistrer' : icon('vertu', 16) . ' Créer la vertu' ?>
                </button>
                <a href="<?= APP_URL ?>/admin/vertus" class="btn btn-secondary">Annuler</a>
            </div>

        </form>

    </main>
</div>
</body>
</html>
