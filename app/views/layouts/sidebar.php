<aside class="sidebar">
    <div class="sidebar-logo">
        <h1>🌿 La Pharmacie</h1>
        <span>Administration</span>
    </div>
    <nav class="sidebar-nav">
        <div class="sidebar-section">Contenu</div>
        <a href="<?= APP_URL ?>/admin"
           class="<?= strpos($_SERVER['REQUEST_URI'], '/admin') !== false && strpos($_SERVER['REQUEST_URI'], '/admin/') === false ? 'active' : '' ?>">
            <span class="icon">🏠</span> Dashboard
        </a>
        <a href="<?= APP_URL ?>/admin/plantes"
           class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/plantes') !== false ? 'active' : '' ?>">
            <span class="icon">🌿</span> Plantes
        </a>
        <a href="<?= APP_URL ?>/admin/composants"
           class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/composants') !== false ? 'active' : '' ?>">
            <span class="icon">🔬</span> Composants
        </a>
        <a href="<?= APP_URL ?>/admin/vertus"
           class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/vertus') !== false ? 'active' : '' ?>">
            <span class="icon">✨</span> Vertus
        </a>
        <a href="<?= APP_URL ?>/admin/categories"
           class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/categories') !== false ? 'active' : '' ?>">
            <span class="icon">📂</span> Catégories
        </a>
        <div class="sidebar-section">Compte</div>
        <a href="<?= APP_URL ?>/logout">
            <span class="icon">🚪</span> Déconnexion
        </a>
    </nav>
    <div class="sidebar-footer">
        <small>Connecté : <?= htmlspecialchars($user['nom'] ?? '') ?></small>
    </div>
</aside>
