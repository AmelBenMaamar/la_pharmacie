<?php
// ================================================
// Controller — classe de base
// ================================================
// Tous les contrôleurs héritent de cette classe.
// Elle fournit les outils communs :
//   - view()     : charge une vue avec ses données
//   - redirect() : redirige vers une URL
//   - flash()    : message temporaire (succès/erreur)
//   - isAdmin()  : vérifie le rôle admin
//   - isAuth()   : vérifie si connecté

class Controller {

    // Charge une vue en lui injectant des variables
    protected function view(string $view, array $data = []): void {
        // Rend les clés du tableau disponibles comme variables
        extract($data);
        $viewPath = APP_ROOT . '/app/views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            die('Vue introuvable : ' . $view);
        }
        require $viewPath;
    }

    // Redirige vers un chemin relatif à APP_URL
    protected function redirect(string $path): void {
        header('Location: ' . APP_URL . $path);
        exit;
    }

    // Enregistre un message flash en session
    protected function flash(string $type, string $message): void {
        $_SESSION['flash'][$type] = $message;
    }

    // Récupère et efface un message flash
    protected function getFlash(string $type): ?string {
        $msg = $_SESSION['flash'][$type] ?? null;
        unset($_SESSION['flash'][$type]);
        return $msg;
    }

    // Vérifie que l'utilisateur est connecté
    protected function requireAuth(): void {
        if (empty($_SESSION['user'])) {
            $this->flash('error', 'Connectez-vous pour accéder à cette page.');
            $this->redirect('/login');
        }
    }

    // Vérifie que l'utilisateur est admin
    protected function requireAdmin(): void {
        $this->requireAuth();
        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            $this->flash('error', 'Accès réservé aux administrateurs.');
            $this->redirect('/');
        }
    }

    // Vérifie un token CSRF
    protected function verifyCsrf(): void {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(403);
            die('Token CSRF invalide.');
        }
    }

    // Génère et stocke un token CSRF
    protected function csrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Retourne l'utilisateur connecté
    protected function user(): ?array {
        return $_SESSION['user'] ?? null;
    }
}
