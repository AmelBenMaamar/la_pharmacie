<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<div style="text-align:center; padding:6rem 2rem;">
    <p style="font-size:5rem; margin-bottom:1rem;">🌿</p>
    <h1 style="font-family:var(--font-serif); font-style:italic; font-size:3rem; background:var(--gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; margin-bottom:0.5rem;">404</h1>
    <p style="color:var(--texte-light); font-size:1.1rem; margin-bottom:2rem;">Cette page n'existe pas dans notre herbier.</p>
    <a href="<?= APP_URL ?>/" class="btn btn-primary">← Retour à l'accueil</a>
</div>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
