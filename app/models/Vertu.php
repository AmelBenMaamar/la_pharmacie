<?php
// ================================================
// Vertu — modèle
// ================================================
// Gère les vertus et leurs liaisons avec :
//   - les plantes    (plante_vertu)
//   - les composants (composant_vertu)

class Vertu extends Model {
    protected string $table = 'vertus';

    // Liste toutes les vertus
    public function all(string $orderBy = 'nom', string $dir = 'ASC'): array {
        return $this->query(
            "SELECT * FROM vertus ORDER BY {$orderBy} {$dir}"
        );
    }

    // Trouve une vertu par son slug
    public function findBySlug(string $slug): ?array {
        return $this->findBy('slug', $slug);
    }

    // Crée une nouvelle vertu
    public function create(array $data): int {
        $slug = $this->slugify($data['nom']);
        $this->execute(
            "INSERT INTO vertus (nom, slug, categorie, description, actif)
             VALUES (?, ?, ?, ?, ?)",
            [
                trim($data['nom']),
                $slug,
                trim($data['categorie'] ?? ''),
                trim($data['description'] ?? ''),
                $data['actif'] ?? 1,
            ]
        );
        return $this->lastInsertId();
    }

    // Met à jour une vertu
    public function update(int $id, array $data): void {
        $slug = $this->slugify($data['nom']);
        $this->execute(
            "UPDATE vertus
             SET nom=?, slug=?, categorie=?, description=?, actif=?
             WHERE id=?",
            [
                trim($data['nom']),
                $slug,
                trim($data['categorie'] ?? ''),
                trim($data['description'] ?? ''),
                $data['actif'] ?? 1,
                $id,
            ]
        );
    }

    // ------------------------------------------------
    // Liaisons — Plantes
    // ------------------------------------------------

    public function plantes(int $vertuId): array {
        return $this->query(
            "SELECT p.*, pv.source FROM plantes p
             JOIN plante_vertu pv ON p.id = pv.plante_id
             WHERE pv.vertu_id = ?
             ORDER BY p.nom",
            [$vertuId]
        );
    }

    // ------------------------------------------------
    // Liaisons — Composants
    // ------------------------------------------------

    public function composants(int $vertuId): array {
        return $this->query(
            "SELECT c.*, cv.niveau_evidence, cv.notes FROM composants c
             JOIN composant_vertu cv ON c.id = cv.composant_id
             WHERE cv.vertu_id = ?
             ORDER BY c.nom",
            [$vertuId]
        );
    }
}
