<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liens — <?= htmlspecialchars($plante['nom']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
<div class="admin-layout">

    <?php include __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="admin-main">

        <div class="page-header">
            <h2>🔗 Liens — <?= htmlspecialchars($plante['nom']) ?></h2>
            <a href="<?= APP_URL ?>/admin/plantes" class="btn btn-secondary">← Retour aux plantes</a>
        </div>

        <?php $flash = $_SESSION['flash']['success'] ?? null; unset($_SESSION['flash']['success']); ?>
        <?php if ($flash): ?>
            <div class="alert alert-success"><?= htmlspecialchars($flash) ?></div>
        <?php endif; ?>

        <!-- ── COMPOSANTS ─────────────────────────────── -->
        <div class="liens-section">
            <h3>🔬 Composants liés</h3>

            <!-- Liste des composants déjà liés -->
            <div class="liens-list">
                <?php if (empty($composants)): ?>
                    <p style="color:var(--texte-light); font-size:0.9rem;">Aucun composant lié pour l'instant.</p>
                <?php else: ?>
                    <?php foreach ($composants as $c): ?>
                        <div class="lien-item">
                            <span class="tag tag-composant"><?= htmlspecialchars($c['nom']) ?>
                                <?php if ($c['concentration']): ?>
                                    <em style="font-size:0.75rem; opacity:0.8"> — <?= htmlspecialchars($c['concentration']) ?></em>
                                <?php endif; ?>
                            </span>
                            <form method="POST" action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens/supprimer">
                                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                                <input type="hidden" name="type" value="composant">
                                <input type="hidden" name="composant_id" value="<?= $c['id'] ?>">
                                <button class="lien-remove" title="Supprimer ce lien">✕</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Ajouter un composant -->
            <form method="POST" action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens"
                  style="display:flex; gap:0.75rem; flex-wrap:wrap; align-items:flex-end;">
                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                <input type="hidden" name="type" value="composant">
                <div class="form-group" style="margin:0; flex:1; min-width:180px;">
                    <label>Composant</label>
                    <select name="composant_id" required>
                        <option value="">— Choisir —</option>
                        <?php foreach ($all_composants as $c): ?>
                            <?php $linked = in_array($c['id'], array_column($composants, 'id')); ?>
                            <option value="<?= $c['id'] ?>" <?= $linked ? 'disabled style="color:#ccc"' : '' ?>>
                                <?= htmlspecialchars($c['nom']) ?><?= $linked ? ' ✓' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" style="margin:0; flex:1; min-width:140px;">
                    <label>Concentration (optionnel)</label>
                    <input type="text" name="concentration" placeholder="ex : 0.5%">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">+ Lier</button>
            </form>
        </div>

        <!-- ── VERTUS ──────────────────────────────────── -->
        <div class="liens-section">
            <h3>✨ Vertus liées</h3>

            <!-- Liste des vertus déjà liées -->
            <div class="liens-list">
                <?php if (empty($vertus)): ?>
                    <p style="color:var(--texte-light); font-size:0.9rem;">Aucune vertu liée pour l'instant.</p>
                <?php else: ?>
                    <?php foreach ($vertus as $v): ?>
                        <div class="lien-item">
                            <span class="tag tag-vertu"><?= htmlspecialchars($v['nom']) ?>
                                <?php if ($v['source']): ?>
                                    <em style="font-size:0.75rem; opacity:0.8"> — <?= htmlspecialchars($v['source']) ?></em>
                                <?php endif; ?>
                            </span>
                            <form method="POST" action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens/supprimer">
                                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                                <input type="hidden" name="type" value="vertu">
                                <input type="hidden" name="vertu_id" value="<?= $v['id'] ?>">
                                <button class="lien-remove" title="Supprimer ce lien">✕</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Ajouter une vertu -->
            <form method="POST" action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens"
                  style="display:flex; gap:0.75rem; flex-wrap:wrap; align-items:flex-end;">
                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                <input type="hidden" name="type" value="vertu">
                <div class="form-group" style="margin:0; flex:1; min-width:180px;">
                    <label>Vertu</label>
                    <select name="vertu_id" required>
                        <option value="">— Choisir —</option>
                        <?php foreach ($all_vertus as $v): ?>
                            <?php $linked = in_array($v['id'], array_column($vertus, 'id')); ?>
                            <option value="<?= $v['id'] ?>" <?= $linked ? 'disabled style="color:#ccc"' : '' ?>>
                                <?= htmlspecialchars($v['nom']) ?><?= $linked ? ' ✓' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" style="margin:0; flex:1; min-width:140px;">
                    <label>Source (optionnel)</label>
                    <input type="text" name="source" placeholder="ex : étude 2021">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">+ Lier</button>
            </form>
        </div>

        
        <!-- ── LIENS COMPOSANT → VERTU ───────────────── -->
        <div class="liens-section">
            <h3>🔗 Liens Composant → Vertu</h3>
            <p style="font-size:0.85rem; color:var(--texte-light); margin-bottom:1rem;">
                Définit quelles vertus sont portées par quels composants actifs — utilisé par le graphe.
            </p>

            <?php
            $model = new Plante();
            foreach ($composants as $comp):
                $vertus_comp = $model->vertusDeComposant($comp['id']);
                $vertus_ids_comp = array_column($vertus_comp, 'id');
            ?>
            <div class="lien-composant-block">
                <div class="lien-composant-header">
                    <span class="tag tag-composant"><?= htmlspecialchars($comp['nom']) ?></span>
                </div>

                <!-- Vertus déjà liées à ce composant -->
                <div class="liens-list liens-list-indent">
                    <?php if (empty($vertus_comp)): ?>
                        <p style="font-size:0.82rem; color:var(--texte-light);">Aucune vertu liée à ce composant.</p>
                    <?php else: ?>
                        <?php foreach ($vertus_comp as $vc): ?>
                        <div class="lien-item">
                            <span class="tag tag-vertu">
                                <?= htmlspecialchars($vc['nom']) ?>
                            </span>
                            <form method="POST" action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens/supprimer">
                                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                                <input type="hidden" name="type" value="composant_vertu">
                                <input type="hidden" name="composant_id" value="<?= $comp['id'] ?>">
                                <input type="hidden" name="vertu_id" value="<?= $vc['id'] ?>">
                                <button class="lien-remove" title="Supprimer ce lien">✕</button>
                            </form>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Ajouter une vertu à ce composant -->
                <form method="POST" action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens"
                      style="display:flex; gap:0.6rem; flex-wrap:wrap; align-items:flex-end; margin-top:0.5rem;">
                    <input type="hidden" name="csrf_token" value="<?= $token ?>">
                    <input type="hidden" name="type" value="composant_vertu">
                    <input type="hidden" name="composant_id" value="<?= $comp['id'] ?>">
                    <div class="form-group" style="margin:0; flex:1; min-width:160px;">
                        <label style="font-size:0.8rem;">Vertu</label>
                        <select name="vertu_id" required>
                            <option value="">— Choisir —</option>
                            <?php foreach ($all_vertus as $av): ?>
                                <?php $already = in_array($av['id'], $vertus_ids_comp); ?>
                                <option value="<?= $av['id'] ?>" <?= $already ? 'disabled style="color:#ccc"' : '' ?>>
                                    <?= htmlspecialchars($av['nom']) ?><?= $already ? ' ✓' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="hidden" name="niveau" value="modere">
                    <button type="submit" class="btn btn-primary btn-sm">+ Lier</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- ── CATEGORIES ──────────────────────────────── -->
        <div class="liens-section">
            <h3>📂 Catégories</h3>

            <div class="liens-list">
                <?php if (empty($categories)): ?>
                    <p style="color:var(--texte-light); font-size:0.9rem;">Aucune catégorie liée.</p>
                <?php else: ?>
                    <?php foreach ($categories as $cat): ?>
                        <div class="lien-item">
                            <span class="tag" style="background:<?= htmlspecialchars($cat['couleur']) ?>22; border-color:<?= htmlspecialchars($cat['couleur']) ?>44; color:<?= htmlspecialchars($cat['couleur']) ?>">
                                <?= htmlspecialchars($cat['nom']) ?>
                            </span>
                            <form method="POST" action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens/supprimer">
                                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                                <input type="hidden" name="type" value="categorie">
                                <input type="hidden" name="categorie_id" value="<?= $cat['id'] ?>">
                                <button class="lien-remove" title="Supprimer ce lien">✕</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Ajouter une catégorie -->
            <form method="POST" action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens"
                  style="display:flex; gap:0.75rem; align-items:flex-end;">
                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                <input type="hidden" name="type" value="categorie">
                <div class="form-group" style="margin:0; flex:1;">
                    <label>Catégorie</label>
                    <select name="categorie_id" required>
                        <option value="">— Choisir —</option>
                        <?php
                        $db = Database::getInstance();
                        $cats = $db->query('SELECT * FROM categories ORDER BY nom')->fetchAll();
                        foreach ($cats as $cat):
                            $linked = in_array($cat['id'], array_column($categories, 'id'));
                        ?>
                            <option value="<?= $cat['id'] ?>" <?= $linked ? 'disabled style="color:#ccc"' : '' ?>>
                                <?= htmlspecialchars($cat['nom']) ?><?= $linked ? ' ✓' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">+ Lier</button>
            </form>
        </div>

    </main>
</div>
</body>
</html>
