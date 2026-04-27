<?php require_once __DIR__ . '/../layouts/icons.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vertus — <?= htmlspecialchars($composant['nom']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
    <style>
        .check-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
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
            cursor: pointer; flex-shrink: 0; margin-top: 3px;
        }
        .check-label { font-size: 0.88rem; color: var(--texte); line-height: 1.3; display: block !important; }
        .check-sub   { font-size: 0.72rem; color: var(--texte-light); display: block; margin-top: 1px; }



        /* Résumé composant en haut */
        .composant-resume {
            background: var(--blanc); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 1rem 1.25rem;
            margin-bottom: 1.5rem; display: flex; align-items: center;
            gap: 1rem; flex-wrap: wrap;
        }
        .composant-resume-icon {
            width: 52px; height: 52px; border-radius: var(--radius);
            background: rgba(107,148,214,0.1); display: flex;
            align-items: center; justify-content: center; flex-shrink: 0;
            color: #2a4a8f;
        }
        .resume-tags { display: flex; gap: 0.4rem; flex-wrap: wrap; margin-left: auto; }

        /* Barre d'enregistrement globale */
        .global-save-bar {
            position: sticky; bottom: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; gap: 1rem;
            padding: 1rem 1.5rem;
            background: var(--blanc);
            border-top: 2px solid var(--turquoise);
            box-shadow: 0 -4px 24px var(--shadow-md);
            margin-top: 2rem;
        }
        .global-save-bar .save-info {
            font-size: 0.85rem; color: var(--texte-light); margin-right: auto;
        }
        .global-save-bar .btn-primary {
            padding: 0.65rem 1.75rem; font-size: 0.95rem;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .select-toggle {
            font-size: 0.78rem; color: var(--texte-light);
            background: none; border: none; cursor: pointer;
            text-decoration: underline; padding: 0; margin-bottom: 0.6rem;
            display: inline-block;
        }
        .select-toggle:hover { color: var(--turquoise); }

        /* Notice info */
        .info-notice {
            display: flex; align-items: flex-start; gap: 0.6rem;
            padding: 0.75rem 1rem;
            background: rgba(107,209,214,0.08);
            border: 1px solid rgba(107,209,214,0.35);
            border-radius: var(--radius);
            font-size: 0.83rem; color: var(--texte-light);
            margin-bottom: 1.25rem;
        }
        .info-notice strong { color: var(--brun-dark); }
    </style>
</head>
<body>
<div class="admin-layout">
    <?php include __DIR__ . '/../layouts/sidebar.php'; ?>
    <main class="admin-main">

        <div class="page-header">
            <h2><?= icon('lien', 20) ?> Vertus — <?= htmlspecialchars($composant['nom']) ?></h2>
            <a href="<?= APP_URL ?>/admin/composants" class="btn btn-secondary btn-sm">← Composants</a>
        </div>

        <?php $flash = $_SESSION['flash']['success'] ?? null; unset($_SESSION['flash']['success']); ?>
        <?php if ($flash): ?>
            <div class="alert alert-success"><?= htmlspecialchars($flash) ?></div>
        <?php endif; ?>

        <!-- Résumé du composant -->
        <div class="composant-resume">
            <div class="composant-resume-icon">
                <?= icon('composant', 28) ?>
            </div>
            <div>
                <strong style="font-family:var(--font-serif); font-size:1.1rem;">
                    <?= htmlspecialchars($composant['nom']) ?>
                </strong>
                <?php if (!empty($composant['famille'])): ?>
                    <em style="display:block; font-size:0.85rem; color:var(--texte-light);">
                        <?= htmlspecialchars($composant['famille']) ?>
                    </em>
                <?php endif; ?>
            </div>
            <?php $nb_v = count($vertus_liees); ?>
            <div class="resume-tags">
                <span class="tag tag-vertu"><?= $nb_v ?> vertu<?= $nb_v > 1 ? 's' : '' ?> liée<?= $nb_v > 1 ? 's' : '' ?></span>
                <?php if (!empty($composant['description'])): ?>
                    <a href="<?= APP_URL ?>/admin/composants/<?= $composant['id'] ?>/editer"
                       class="btn btn-sm btn-secondary"><?= icon('edit', 13) ?> Éditer</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Notice explicative -->
        <div class="info-notice">
            <?= icon('vertu', 15) ?>
            <span>
                Les vertus cochées ici seront <strong>propagées automatiquement</strong> à toutes les plantes
                qui contiennent ce composant — graphe, fiches publiques, page d'accueil.
                Le niveau d'évidence s'affiche sur les fiches publiques.
            </span>
        </div>

        <!-- Formulaire unique -->
        <form method="POST"
              action="<?= APP_URL ?>/admin/composants/<?= $composant['id'] ?>/vertus/bulk"
              id="form-vertus">
            <input type="hidden" name="csrf_token" value="<?= $token ?>">

            <div class="liens-section">
                <h3><?= icon('vertu', 16, 'section-icon vertu') ?> Vertus thérapeutiques</h3>
                <p style="font-size:0.85rem; color:var(--texte-light); margin-bottom:0.75rem;">
                    Coche les vertus portées par <strong><?= htmlspecialchars($composant['nom']) ?></strong>.
                    Le niveau d'évidence apparaît après avoir coché.
                </p>

                <?php $vertus_ids = array_column($vertus_liees, 'id'); ?>

                <button type="button" class="select-toggle" onclick="toggleAll('grid-vertus')">
                    Tout sélectionner / désélectionner
                </button>

                <div class="check-grid" id="grid-vertus">
                    <?php foreach ($all_vertus as $v): if (empty($v['nom'])) continue;
                        $checked = in_array($v['id'], $vertus_ids); ?>
                        <label class="check-item <?= $checked ? 'is-checked' : '' ?>">
                            <input type="checkbox"
                                   name="vertus[<?= $v['id'] ?>][actif]"
                                   value="1"
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

                <p style="font-size:0.78rem; color:var(--texte-light); margin-top:0.25rem;">
                    <span id="cnt-vertus"><?= $nb_v ?> sélectionnée<?= $nb_v > 1 ? 's' : '' ?></span>
                </p>
            </div>

            <!-- Barre globale -->
            <div class="global-save-bar">
                <span class="save-info">
                    Ces vertus seront visibles sur toutes les plantes contenant ce composant.
                </span>
                <button type="submit" class="btn btn-primary">
                    <?= icon('save', 17) ?> Enregistrer les vertus
                </button>
            </div>

        </form>

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
    if (el) el.textContent = n + ' sélectionnée' + (n > 1 ? 's' : '');
}
</script>
</body>
</html>
