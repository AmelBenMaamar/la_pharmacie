<?php require_once APP_ROOT . '/app/views/layouts/icons.php'; ?>
<aside class="sidebar">
    <a href="<?= APP_URL ?>/" class="sidebar-logo" target="_blank">
        <?= icon('plante', 22, 'logo-icon') ?>
        <div>
            <h1>La Pharmacie</h1>
            <span>Administration</span>
        </div>
    </a>
    <nav class="sidebar-nav">
        <div class="sidebar-section">Contenu</div>
        <a href="<?= APP_URL ?>/admin"
           class="<?= strpos($_SERVER['REQUEST_URI'], '/admin') !== false && strpos($_SERVER['REQUEST_URI'], '/admin/') === false ? 'active' : '' ?>">
            <span class="icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
            </span>
            Dashboard
        </a>
        <a href="<?= APP_URL ?>/admin/plantes"
           class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/plantes') !== false ? 'active' : '' ?>">
            <span class="icon"><?= icon('plante', 16) ?></span>
            Plantes
        </a>
        <a href="<?= APP_URL ?>/admin/composants"
           class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/composants') !== false ? 'active' : '' ?>">
            <span class="icon"><?= icon('composant', 16) ?></span>
            Composants
        </a>
        <a href="<?= APP_URL ?>/admin/vertus"
           class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/vertus') !== false ? 'active' : '' ?>">
            <span class="icon"><?= icon('vertu', 16) ?></span>
            Vertus
        </a>
        <a href="<?= APP_URL ?>/admin/categories"
           class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/categories') !== false ? 'active' : '' ?>">
        <a href="<?= APP_URL ?>/admin/sources"
           class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/sources') !== false ? 'active' : '' ?>">
            <span class="icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            </span>
            Sources
        </a>
            <span class="icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18M3 12h18M3 18h18"/>
                </svg>
            </span>
            Catégories
        </a>
        <div class="sidebar-section">Compte</div>
        <a href="<?= APP_URL ?>/logout">
            <span class="icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
            </span>
            Déconnexion
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar"><?= strtoupper(substr($user['nom'] ?? 'A', 0, 1)) ?></div>
            <div>
                <div class="sidebar-user-name"><?= htmlspecialchars($user['nom'] ?? '') ?></div>
                <div class="sidebar-user-role">Administrateur</div>
            </div>
        </div>
    </div>
</aside>
