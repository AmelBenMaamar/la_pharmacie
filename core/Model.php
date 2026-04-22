<?php
// ================================================
// Model — classe de base
// ================================================
// Tous les modèles héritent de cette classe.
// Elle fournit les opérations CRUD communes :
//   - find()    : récupère un enregistrement par id
//   - all()     : récupère tous les enregistrements
//   - create()  : insère un nouvel enregistrement
//   - update()  : met à jour un enregistrement
//   - delete()  : supprime un enregistrement
//   - query()   : exécute une requête personnalisée

class Model {
    protected PDO $db;
    protected string $table = '';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Récupère un enregistrement par son id
    public function find(int $id): ?array {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id = ?"
        );
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    // Récupère un enregistrement par un champ
    public function findBy(string $field, mixed $value): ?array {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE {$field} = ?"
        );
        $stmt->execute([$value]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    // Récupère tous les enregistrements
    public function all(string $orderBy = 'id', string $dir = 'ASC'): array {
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table} ORDER BY {$orderBy} {$dir}"
        );
        return $stmt->fetchAll();
    }

    // Supprime un enregistrement par son id
    public function delete(int $id): void {
        $stmt = $this->db->prepare(
            "DELETE FROM {$this->table} WHERE id = ?"
        );
        $stmt->execute([$id]);
    }

    // Exécute une requête personnalisée avec paramètres
    protected function query(string $sql, array $params = []): array {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Exécute une requête sans retour (INSERT, UPDATE, DELETE)
    protected function execute(string $sql, array $params = []): void {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
    }

    // Retourne le dernier id inséré
    protected function lastInsertId(): int {
        return (int) $this->db->lastInsertId();
    }

    // Génère un slug à partir d'une chaîne
    protected function slugify(string $str): string {
        $str = mb_strtolower(trim($str), 'UTF-8');
        $str = preg_replace('/[àáâãäå]/u', 'a', $str);
        $str = preg_replace('/[éèêë]/u',   'e', $str);
        $str = preg_replace('/[îï]/u',     'i', $str);
        $str = preg_replace('/[ôö]/u',     'o', $str);
        $str = preg_replace('/[ùûü]/u',    'u', $str);
        $str = preg_replace('/[ç]/u',      'c', $str);
        $str = preg_replace('/[^a-z0-9]+/', '-', $str);
        return trim($str, '-');
    }
}
