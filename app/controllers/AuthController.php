<?php
// ================================================
// AuthController — authentification
// ================================================
// Gère le login et le logout.
//   - loginForm() : affiche le formulaire
//   - login()     : vérifie email + password
//   - logout()    : détruit la session

class AuthController extends Controller {

    // Affiche le formulaire de connexion
    public function loginForm(): void {
        // Si déjà connecté → redirige vers l'admin
        if (!empty($_SESSION['user'])) {
            $this->redirect('/admin');
        }
        $error   = $this->getFlash('error');
        $success = $this->getFlash('success');
        $this->view('auth/login', [
            'error'   => $error,
            'success' => $success,
            'token'   => $this->csrfToken(),
        ]);
    }

    // Traite le formulaire de connexion
    public function login(): void {
        $this->verifyCsrf();

        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');

        // Validation basique
        if (empty($email) || empty($password)) {
            $this->flash('error', 'Email et mot de passe requis.');
            $this->redirect('/login');
        }

        // Cherche l'utilisateur
        $userModel = new User();
        $user      = $userModel->findByEmail($email);

        // Vérifie le mot de passe et que le compte est actif
        if (!$user || !password_verify($password, $user['password'])) {
            $this->flash('error', 'Email ou mot de passe incorrect.');
            $this->redirect('/login');
        }

        if (!$user['actif']) {
            $this->flash('error', 'Votre compte est désactivé.');
            $this->redirect('/login');
        }

        // Stocke l'utilisateur en session
        $_SESSION['user'] = [
            'id'   => $user['id'],
            'nom'  => $user['nom'],
            'email'=> $user['email'],
            'role' => $user['role'],
        ];

        // Redirige selon le rôle
        if ($user['role'] === 'admin') {
            $this->redirect('/admin');
        } else {
            $this->redirect('/');
        }
    }

    // Déconnexion
    public function logout(): void {
        session_destroy();
        header('Location: ' . APP_URL . '/login');
        exit;
    }
}
