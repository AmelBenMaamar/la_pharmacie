<?php require_once APP_ROOT . '/app/views/layouts/icons.php'; ?>

    <footer class="public-footer">
        <div class="footer-inner">

            <div class="footer-brand">
                <?= icon('plante', 32, 'footer-icon') ?>
                <div class="footer-brand-text">
                    <span class="footer-title">La Pharmacie</span>
                    <p class="footer-tagline">Herbier interactif botanique</p>
                </div>
            </div>

            <nav class="footer-nav">
                <a href="<?= APP_URL ?>/#plantes">
                    <?= icon('plante', 14) ?> Plantes
                </a>
                <a href="<?= APP_URL ?>/#composants">
                    <?= icon('composant', 14) ?> Composants
                </a>
                <a href="<?= APP_URL ?>/#vertus">
                    <?= icon('vertu', 14) ?> Vertus
                </a>
            </nav>

            <nav class="footer-nav">
                <a href="https://github.com/AmelBenMaamar/la_pharmacie" target="_blank" rel="noopener">GitHub</a>
                <a href="<?= APP_URL ?>/login">Admin</a>
            </nav>

        </div>

        <div class="footer-bottom">
            <div class="footer-gradient-bar"></div>
            <p>© <?= date('Y') ?> <strong>AmelCerise</strong> — Tous droits réservés</p>
        </div>
    </footer>

    <script src="<?= APP_URL ?>/js/app.js"></script>
</body>
</html>
