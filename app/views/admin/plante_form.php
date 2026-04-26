<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $plante ? 'Éditer' : 'Créer' ?> une plante — La Pharmacie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
<div class="admin-layout">

    <?php include __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="admin-main">

        <div class="page-header">
            <h2><?= $plante ? icon('edit', 16) . ' Éditer : ' . htmlspecialchars($plante['nom']) : icon('plante', 16) . ' Nouvelle plante' ?></h2>
            <a href="<?= APP_URL ?>/admin/plantes" class="btn btn-secondary">← Retour</a>
        </div>

        <form class="admin-form"
              method="POST"
              enctype="multipart/form-data"
              action="<?= $plante
                ? APP_URL . '/admin/plantes/' . $plante['id'] . '/editer'
                : APP_URL . '/admin/plantes/creer' ?>">

            <input type="hidden" name="csrf_token" value="<?= $this->csrfToken() ?>">

            <!-- Image -->
            <div class="form-group">
                <label>Image</label>
                <?php if (!empty($plante['image'])): ?>
                    <div style="margin-bottom: 0.75rem;">
                        <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($plante['image']) ?>"
                             class="upload-preview" alt="Image actuelle">
                        <small style="color:var(--texte-light)">Image actuelle — uploadez-en une nouvelle pour la remplacer</small>
                    </div>
                <?php endif; ?>
                <label class="upload-zone" for="image">
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp"
                           onchange="previewImage(this)">
                    <div id="upload-placeholder">
                        <div style="font-size:2rem; margin-bottom:0.5rem;">📷</div>
                        <div style="font-weight:500; color:var(--brun)">Cliquez pour choisir une image</div>
                        <div style="font-size:0.8rem; color:var(--texte-light); margin-top:0.25rem">JPG, PNG, WebP — max 5Mo</div>
                    </div>
                    <img id="image-preview" src="" alt="Aperçu"
                         style="display:none; max-height:200px; margin:0 auto; border-radius:8px;">
                </label>
            </div>

            <!-- Nom -->
            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom commun <span style="color:#c0392b">*</span></label>
                    <input type="text" id="nom" name="nom" required
                           placeholder="ex : Lavande"
                           value="<?= htmlspecialchars($plante['nom'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="nom_latin">Nom latin</label>
                    <input type="text" id="nom_latin" name="nom_latin"
                           placeholder="ex : Lavandula angustifolia"
                           value="<?= htmlspecialchars($plante['nom_latin'] ?? '') ?>">
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                          placeholder="Décrivez cette plante, son origine, ses caractéristiques..."
                          rows="5"><?= htmlspecialchars($plante['description'] ?? '') ?></textarea>
            </div>

            <!-- Statut -->
            <div class="form-group">
                <label for="actif">Statut</label>
                <select id="actif" name="actif">
                    <option value="1" <?= ($plante['actif'] ?? 1) == 1 ? 'selected' : '' ?>>✅ Publié</option>
                    <option value="0" <?= ($plante['actif'] ?? 1) == 0 ? 'selected' : '' ?>>🔒 Masqué</option>
                </select>
            </div>

            <!-- Boutons -->
            <div style="display:flex; gap:1rem; margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <?= $plante ? icon('save', 16) . ' Enregistrer les modifications' : icon('plante', 16) . ' Créer la plante' ?>
                </button>
                <a href="<?= APP_URL ?>/admin/plantes" class="btn btn-secondary">Annuler</a>
            </div>

        </form>

    </main>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('upload-placeholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</body>
</html>
