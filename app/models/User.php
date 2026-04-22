<?php
// ================================================
// User — modèle utilisateur
// ================================================
// Gère tout ce qui touche aux utilisateurs :
//   - findByEmail() : trouve un user par email
//     (utilisé pour le login)
//   - create()      : crée un nouveau compte
//   - all()         : liste tous les users (admin)
//   - toggle()      : active/désactive un compte

class User extends Model {
    protected string $table = 'users';

    // Trouve un utilisateur par son email
    public function findByEmail(string $email): ?array {
        return $this->findBy('email', $email);
    }

    // Crée un nouvel utilisateur
    public function create(array $data): int {
        $this->execute(
            "INSERT INTO users (nom, email, password, role)
             VALUES (?, ?, ?, ?)",
            [
                trim($data['nom']),
                trim($data['email']),
                password_hash($data['password'], PASSWORD_BCRYPT),
                $data['role'] ?? 'user',
            ]
        );
        return $this->lastInsertId();
    }

    // Liste tous les utilisateurs
    public function all(string $orderBy = 'created_at', string $dir = 'DESC'): array {
        return $this->query(
            "SELECT id, nom, email, role, actif, created_at
             FROM users
             ORDER BY {$orderBy} {$dir}"
        );
    }

    // Active ou désactive un compte
    public function toggle(int $id): void {
        $this->execute(
            "UPDATE users SET actif = NOT actif WHERE id = ?",
            [$id]
        );
    }

    // Vérifie si un email existe déjà
    public function emailExists(string $email): bool {
        $result = $this->query(
            "SELECT id FROM users WHERE email = ?",
            [trim($email)]
        );
        return !empty($result);
    }
}
