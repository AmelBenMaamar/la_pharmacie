<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $categorie ? 'Éditer' : 'Créer' ?> une catégorie — La Pharmacie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
<div class="admin-layout">

    <?php include __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="admin-main">

        <div class="page-header">
            <h2><?= $categorie ? icon('edit', 16) . ' Éditer : ' . htmlspecialchars($categorie['nom']) : icon('categorie', 16) . ' Nouvelle catégorie' ?></h2>
            <a href="<?= APP_URL ?>/admin/categories" class="btn btn-secondary">← Retour</a>
        </div>

        <form class="admin-form"
              method="POST"
              action="<?= $categorie
                ? APP_URL . '/admin/categories/' . $categorie['id'] . '/editer'
                : APP_URL . '/admin/categories/creer' ?>">

            <input type="hidden" name="csrf_token" value="<?= $this->csrfToken() ?>">

            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom <span style="color:#c0392b">*</span></label>
                    <input type="text" id="nom" name="nom" required
                           placeholder="ex : Aromatiques"
                           value="<?= htmlspecialchars($categorie['nom'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="couleur">Couleur</label>
                    <div style="display:flex; gap:0.75rem; align-items:center;">
                        <input type="color" id="couleur" name="couleur"
                               value="<?= htmlspecialchars($categorie['couleur'] ?? '#4a7c59') ?>"
                               style="width:50px;height:42px;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;padding:2px;">
                        <span id="couleur-val" style="font-size:0.85rem;color:var(--texte-light)">
                            <?= htmlspecialchars($categorie['couleur'] ?? '#4a7c59') ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3"
                          placeholder="Décrivez cette catégorie..."><?= htmlspecialchars($categorie['description'] ?? '') ?></textarea>
            </div>

            <div style="display:flex; gap:1rem; margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <?= $categorie ? icon('save', 16) . ' Enregistrer' : icon('categorie', 16) . ' Créer la catégorie' ?>
                </button>
                <a href="<?= APP_URL ?>/admin/categories" class="btn btn-secondary">Annuler</a>
            </div>

        </form>

    </main>
</div>

<script>
document.getElementById('couleur').addEventListener('input', function() {
    document.getElementById('couleur-val').textContent = this.value;
});
</script>

</body>
</html>
