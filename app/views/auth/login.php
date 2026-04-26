<?php require_once dirname(__DIR__) . "/layouts/icons.php"; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — La Pharmacie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body class="auth-page">

    <div class="auth-container">

        <!-- Logo / Titre -->
        <div class="auth-header">
            <div class="auth-logo"><?= icon('plante', 48, 'logo-icon') ?></div>
            <h1 class="auth-title">La Pharmacie</h1>
            <p class="auth-subtitle">Votre herbier interactif</p>
        </div>

        <!-- Messages flash -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <!-- Formulaire -->
        <form class="auth-form" method="POST" action="<?= APP_URL ?>/login">
            <input type="hidden" name="csrf_token" value="<?= $token ?>">

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="votre@email.fr"
                    required
                    autocomplete="email"
                >
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                Se connecter
            </button>
        </form>

    </div>

</body>
</html>
