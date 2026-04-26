<?php require_once __DIR__ . '/../layouts/icons.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liens — <?= htmlspecialchars($plante['nom']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
    <style>
        .check-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .check-item {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            padding: 0.6rem 0.85rem;
            border-radius: var(--radius);
            border: 1.5px solid var(--border);
            background: var(--creme);
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
            user-select: none;
        }
        .check-item:hover { border-color: var(--turquoise); background: rgba(107,209,214,0.06); }
        .check-item.is-checked { border-color: var(--turquoise); background: rgba(107,209,214,0.1); }
        .check-item.is-checked .check-label { font-weight: 500; color: var(--brun-dark); }
        .check-item input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--turquoise);
            cursor: pointer; flex-shrink: 0; margin-top: 2px;
        }
        .check-label { font-size: 0.88rem; color: var(--texte); line-height: 1.3; display: block !important; }
        .check-sub { font-size: 0.72rem; color: var(--texte-light); display: block; margin-top: 1px; }
        .conc-field { display: none; margin-top: 0.4rem; }
        .check-item.is-checked .conc-field { display: block; }
        .conc-field input {
            width: 100%; padding: 0.25rem 0.5rem; font-size: 0.8rem;
            border: 1px solid var(--border); border-radius: var(--radius);
            background: var(--blanc); font-family: var(--font-sans);
        }
        .save-bar {
            position: sticky; bottom: 1rem;
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            background: var(--blanc);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: 0 4px 20px var(--shadow-md);
            margin-top: 0.75rem;
        }
        .save-bar .count-badge { font-size: 0.82rem; color: var(--texte-light); margin-right: auto; }
        .select-toggle {
            font-size: 0.78rem; color: var(--texte-light);
            background: none; border: none; cursor: pointer;
            text-decoration: underline; padding: 0; margin-bottom: 0.6rem;
            display: inline-block;
        }
        .select-toggle:hover { color: var(--turquoise); }
        .plante-resume {
            background: var(--blanc); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 1rem 1.25rem;
            margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        }
        .plante-resume-img {
            width: 52px; height: 52px; object-fit: cover;
            border-radius: var(--radius); border: 1px solid var(--border); flex-shrink: 0;
        }
        .plante-resume-placeholder {
            width: 52px; height: 52px; border-radius: var(--radius);
            background: var(--creme-dark); display: flex;
            align-items: center; justify-content: center; flex-shrink: 0;
        }
        .resume-tags { display: flex; gap: 0.4rem; flex-wrap: wrap; margin-left: auto; }
        .comp-block { margin-bottom: 1.25rem; padding-bottom: 1.25rem; border-bottom: 1px solid var(--border); }
        .comp-block:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .comp-block-header { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.6rem; }
    </style>
</head>
<body>
<div class="admin-layout">
    <?php include __DIR__ . '/../layouts/sidebar.php'; ?>
    <main class="admin-main">

        <div class="page-header">
            <h2><?= icon('lien', 20) ?> Liens — <?= htmlspecialchars($plante['nom']) ?></h2>
            <a href="<?= APP_URL ?>/admin/plantes" class="btn btn-secondary btn-sm">← Plantes</a>
        </div>

        <?php $flash = $_SESSION['flash']['success'] ?? null; unset($_SESSION['flash']['success']); ?>
        <?php if ($flash): ?>
            <div class="alert alert-success"><?= htmlspecialchars($flash) ?></div>
        <?php endif; ?>

        <div class="plante-resume">
            <?php if (!empty($plante['image'])): ?>
                <img class="plante-resume-img"
                     src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($plante['image']) ?>"
                     alt="<?= htmlspecialchars($plante['nom']) ?>">
            <?php else: ?>
                <div class="plante-resume-placeholder"><?= icon('plante', 26, 'placeholder-icon') ?></div>
            <?php endif; ?>
            <div>
                <strong style="font-family:var(--font-serif); font-size:1.1rem;">
                    <?= htmlspecialchars($plante['nom']) ?>
                </strong>
                <?php if (!empty($plante['nom_latin'])): ?>
                    <em style="display:block; font-size:0.85rem; color:var(--texte-light);">
                        <?= htmlspecialchars($plante['nom_latin']) ?>
                    </em>
                <?php endif; ?>
            </div>
            <?php $nb_c = count($composants); $nb_v = count($vertus); $nb_cat = count($categories); ?>
            <div class="resume-tags">
                <span class="tag tag-composant"><?= $nb_c ?> composant<?= $nb_c > 1 ? 's' : '' ?></span>
                <span class="tag tag-vertu"><?= $nb_v ?> vertu<?= $nb_v > 1 ? 's' : '' ?></span>
                <span class="tag tag-plante"><?= $nb_cat ?> catégorie<?= $nb_cat > 1 ? 's' : '' ?></span>
            </div>
        </div>

        <!-- ══ COMPOSANTS ════════════════════════════ -->
        <div class="liens-section">
            <h3><?= icon('composant', 16, 'section-icon composant') ?> Composants actifs</h3>
            <p style="font-size:0.85rem; color:var(--texte-light); margin-bottom:0.75rem;">
                Coche les composants présents dans cette plante. La concentration s'affiche après avoir coché.
            </p>
            <form method="POST" action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens/bulk">
                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                <input type="hidden" name="section" value="composants">
                <?php
                $composants_ids     = array_column($composants, 'id');
                $concentrations_map = array_column($composants, 'concentration', 'id');
                ?>
                <button type="button" class="select-toggle" onclick="toggleAll('grid-composants')">
                    Tout sélectionner / désélectionner
                </button>
                <div class="check-grid" id="grid-composants">
                    <?php foreach ($all_composants as $c): if (empty($c['nom'])) continue;
                        $checked = in_array($c['id'], $composants_ids); ?>
                        <label class="check-item <?= $checked ? 'is-checked' : '' ?>">
                            <input type="checkbox"
                                   name="composants[<?= $c['id'] ?>][actif]"
                                   value="1"
                                   <?= $checked ? 'checked' : '' ?>
                                   onchange="toggleCheck(this); updateCount('grid-composants', 'cnt-composants')">
                            <div style="flex:1; min-width:0;">
                                <span class="check-label"><?= htmlspecialchars($c['nom']) ?></span>
                                <?php if (!empty($c['famille'])): ?>
                                    <span class="check-sub"><?= htmlspecialchars($c['famille']) ?></span>
                                <?php endif; ?>
                                <div class="conc-field">
                                    <input type="text"
                                           name="composants[<?= $c['id'] ?>][concentration]"
                                           value="<?= htmlspecialchars($concentrations_map[$c['id']] ?? '') ?>"
                                           placeholder="Concentration…"
                                           onclick="event.stopPropagation()">
                                </div>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
                <div class="save-bar">
                    <span class="count-badge" id="cnt-composants">
                        <?= $nb_c ?> sélectionné<?= $nb_c > 1 ? 's' : '' ?>
                    </span>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <?= icon('save', 15) ?> Enregistrer les composants
                    </button>
                </div>
            </form>
        </div>

        <!-- ══ VERTUS ════════════════════════════════ -->
        <div class="liens-section">
            <h3><?= icon('vertu', 16, 'section-icon vertu') ?> Vertus thérapeutiques</h3>
            <p style="font-size:0.85rem; color:var(--texte-light); margin-bottom:0.75rem;">
                Coche les vertus associées à cette plante.
            </p>
            <form method="POST" action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens/bulk">
                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                <input type="hidden" name="section" value="vertus">
                <?php $vertus_ids = array_column($vertus, 'id'); ?>
                <button type="button" class="select-toggle" onclick="toggleAll('grid-vertus')">
                    Tout sélectionner / désélectionner
                </button>
                <div class="check-grid" id="grid-vertus">
                    <?php foreach ($all_vertus as $v): if (empty($v['nom'])) continue;
                        $checked = in_array($v['id'], $vertus_ids); ?>
                        <label class="check-item <?= $checked ? 'is-checked' : '' ?>">
                            <input type="checkbox"
                                   name="vertus[]"
                                   value="<?= $v['id'] ?>"
                                   <?= $checked ? 'checked' : '' ?>
                                   onchange="toggleCheck(this); updateCount('grid-vertus', 'cnt-vertus')">
                            <div style="flex:1; min-width:0;">
                                <span class="check-label"><?= htmlspecialchars($v['nom']) ?></span>
                                <?php if (!empty($v['categorie'])): ?>
                                    <span class="check-sub"><?= htmlspecialchars($v['categorie']) ?></span>
                                <?php endif; ?>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
                <div class="save-bar">
                    <span class="count-badge" id="cnt-vertus">
                        <?= $nb_v ?> sélectionnée<?= $nb_v > 1 ? 's' : '' ?>
                    </span>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <?= icon('save', 15) ?> Enregistrer les vertus
                    </button>
                </div>
            </form>
        </div>

        <!-- ══ COMPOSANT → VERTU (graphe) ════════════ -->
        <?php if (!empty($composants)): ?>
        <div class="liens-section">
            <h3><?= icon('lien', 16) ?> Liens Composant → Vertu
                <small style="font-size:0.78rem; color:var(--texte-light); font-family:var(--font-sans);">graphe</small>
            </h3>
            <p style="font-size:0.85rem; color:var(--texte-light); margin-bottom:1rem;">
                Pour chaque composant, coche les vertus qu'il porte directement.
            </p>
            <form method="POST" action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens/bulk">
                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                <input type="hidden" name="section" value="composant_vertu">
                <?php $model = new Plante();
                foreach ($composants as $comp):
                    $vertus_comp = $model->vertusDeComposant($comp['id']);
                    $vids_comp   = array_column($vertus_comp, 'id');
                    $nb_cv       = count($vertus_comp); ?>
                    <div class="comp-block">
                        <div class="comp-block-header">
                            <span class="tag tag-composant"><?= htmlspecialchars($comp['nom']) ?></span>
                            <span style="font-size:0.78rem; color:var(--texte-light);">
                                <?= $nb_cv ?> vertu<?= $nb_cv > 1 ? 's' : '' ?> liée<?= $nb_cv > 1 ? 's' : '' ?>
                            </span>
                        </div>
                        <div class="check-grid">
                            <?php foreach ($all_vertus as $av): if (empty($av['nom'])) continue;
                                $checked = in_array($av['id'], $vids_comp); ?>
                                <label class="check-item <?= $checked ? 'is-checked' : '' ?>">
                                    <input type="checkbox"
                                           name="cv[<?= $comp['id'] ?>][]"
                                           value="<?= $av['id'] ?>"
                                           <?= $checked ? 'checked' : '' ?>
                                           onchange="toggleCheck(this)">
                                    <span class="check-label"><?= htmlspecialchars($av['nom']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="save-bar">
                    <span class="count-badge">Graphe composant → vertu</span>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <?= icon('save', 15) ?> Enregistrer le graphe
                    </button>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <!-- ══ CATÉGORIES ════════════════════════════ -->
        <div class="liens-section">
            <h3><?= icon('categorie', 16, 'section-icon') ?> Catégories</h3>
            <form method="POST" action="<?= APP_URL ?>/admin/plantes/<?= $plante['id'] ?>/liens/bulk">
                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                <input type="hidden" name="section" value="categories">
                <?php
                $db       = Database::getInstance();
                $all_cats = $db->query('SELECT * FROM categories ORDER BY nom')->fetchAll();
                $cat_ids  = array_column($categories, 'id');
                ?>
                <div class="check-grid">
                    <?php foreach ($all_cats as $cat): if (empty($cat['nom'])) continue;
                        $checked = in_array($cat['id'], $cat_ids); ?>
                        <label class="check-item <?= $checked ? 'is-checked' : '' ?>"
                               style="<?= $checked ? 'border-color:' . htmlspecialchars($cat['couleur']) . '88;' : '' ?>">
                            <input type="checkbox"
                                   name="categories[]"
                                   value="<?= $cat['id'] ?>"
                                   <?= $checked ? 'checked' : '' ?>
                                   onchange="toggleCheck(this)">
                            <span class="check-label"
                                  style="<?= $checked ? 'color:' . htmlspecialchars($cat['couleur']) . ';' : '' ?>">
                                <?= htmlspecialchars($cat['nom']) ?>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>
                <div class="save-bar">
                    <span class="count-badge"><?= $nb_cat ?> catégorie<?= $nb_cat > 1 ? 's' : '' ?> sélectionnée<?= $nb_cat > 1 ? 's' : '' ?></span>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <?= icon('save', 15) ?> Enregistrer les catégories
                    </button>
                </div>
            </form>
        </div>

    </main>
</div>
<script>
function toggleCheck(cb) {
    cb.closest('.check-item').classList.toggle('is-checked', cb.checked);
}
function toggleAll(gridId) {
    const cbs = [...document.querySelectorAll('#' + gridId + ' input[type="checkbox"]')];
    const anyUnchecked = cbs.some(c => !c.checked);
    cbs.forEach(c => {
        c.checked = anyUnchecked;
        c.closest('.check-item').classList.toggle('is-checked', anyUnchecked);
    });
}
function updateCount(gridId, countId) {
    const n  = document.querySelectorAll('#' + gridId + ' input:checked').length;
    const el = document.getElementById(countId);
    if (el) el.textContent = n + ' sélectionné' + (n > 1 ? 's' : '');
}
</script>
</body>
</html>
