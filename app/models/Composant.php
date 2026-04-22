<?php
// ================================================
// Composant — modèle
// ================================================
// Gère les composants et leurs liaisons avec :
//   - les plantes  (plante_composant)
//   - les vertus   (composant_vertu)

class Composant extends Model {
    protected string $table = 'composants';

    // Liste tous les composants
    public function all(string $orderBy = 'nom', string $dir = 'ASC'): array {
        return $this->query(
            "SELECT * FROM composants ORDER BY {$orderBy} {$dir}"
        );
    }

    // Trouve un composant par son slug
    public function findBySlug(string $slug): ?array {
        return $this->findBy('slug', $slug);
    }

    // Crée un nouveau composant
    public function create(array $data): int {
        $slug = $this->slugify($data['nom']);
        $this->execute(
            "INSERT INTO composants (nom, slug, famille, description, actif)
             VALUES (?, ?, ?, ?, ?)",
            [
                trim($data['nom']),
                $slug,
                trim($data['famille'] ?? ''),
                trim($data['description'] ?? ''),
                $data['actif'] ?? 1,
            ]
        );
        return $this->lastInsertId();
    }

    // Met à jour un composant
    public function update(int $id, array $data): void {
        $slug = $this->slugify($data['nom']);
        $this->execute(
            "UPDATE composants
             SET nom=?, slug=?, famille=?, description=?, actif=?
             WHERE id=?",
            [
                trim($data['nom']),
                $slug,
                trim($data['famille'] ?? ''),
                trim($data['description'] ?? ''),
                $data['actif'] ?? 1,
                $id,
            ]
        );
    }

    // ------------------------------------------------
    // Liaisons — Plantes
    // ------------------------------------------------

    public function plantes(int $composantId): array {
        return $this->query(
            "SELECT p.*, pc.concentration, pc.notes FROM plantes p
             JOIN plante_composant pc ON p.id = pc.plante_id
             WHERE pc.composant_id = ?
             ORDER BY p.nom",
            [$composantId]
        );
    }

    // ------------------------------------------------
    // Liaisons — Vertus
    // ------------------------------------------------

    public function vertus(int $composantId): array {
        return $this->query(
            "SELECT v.*, cv.niveau_evidence, cv.notes FROM vertus v
             JOIN composant_vertu cv ON v.id = cv.vertu_id
             WHERE cv.composant_id = ?
             ORDER BY v.nom",
            [$composantId]
        );
    }

    public function linkVertu(int $composantId, int $vertuId, string $niveau = 'modere', string $notes = ''): void {
        $this->execute(
            "INSERT IGNORE INTO composant_vertu
             (composant_id, vertu_id, niveau_evidence, notes)
             VALUES (?, ?, ?, ?)",
            [$composantId, $vertuId, $niveau, $notes]
        );
    }

    public function unlinkVertu(int $composantId, int $vertuId): void {
        $this->execute(
            "DELETE FROM composant_vertu
             WHERE composant_id=? AND vertu_id=?",
            [$composantId, $vertuId]
        );
    }
}
