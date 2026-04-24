<?php
class Plante extends Model {
    protected string $table = 'plantes';

    public function all(string $orderBy = 'nom', string $dir = 'ASC'): array {
        return $this->query("SELECT * FROM plantes ORDER BY {$orderBy} {$dir}");
    }

    public function findBySlug(string $slug): ?array {
        return $this->findBy('slug', $slug);
    }

    public function create(array $data): int {
        $slug = $this->slugify($data['nom']);
        $this->execute(
            "INSERT INTO plantes (nom, nom_latin, slug, description, image, actif)
             VALUES (?, ?, ?, ?, ?, ?)",
            [
                trim($data['nom']),
                trim($data['nom_latin'] ?? ''),
                $slug,
                trim($data['description'] ?? ''),
                $data['image'] ?? null,
                $data['actif'] ?? 1,
            ]
        );
        return $this->lastInsertId();
    }

    // ✅ image incluse dans le UPDATE
    public function update(int $id, array $data): void {
        $slug = $this->slugify($data['nom']);
        $this->execute(
            "UPDATE plantes
             SET nom=?, nom_latin=?, slug=?, description=?, image=?, actif=?
             WHERE id=?",
            [
                trim($data['nom']),
                trim($data['nom_latin'] ?? ''),
                $slug,
                trim($data['description'] ?? ''),
                $data['image'] ?? null,
                $data['actif'] ?? 1,
                $id,
            ]
        );
    }

    public function updateImage(int $id, string $image): void {
        $this->execute("UPDATE plantes SET image=? WHERE id=?", [$image, $id]);
    }

    public function categories(int $planteId): array {
        return $this->query(
            "SELECT c.* FROM categories c
             JOIN plante_categorie pc ON c.id = pc.categorie_id
             WHERE pc.plante_id = ? ORDER BY c.nom",
            [$planteId]
        );
    }

    public function linkCategorie(int $planteId, int $categorieId): void {
        $this->execute(
            "INSERT IGNORE INTO plante_categorie (plante_id, categorie_id) VALUES (?, ?)",
            [$planteId, $categorieId]
        );
    }

    public function unlinkCategorie(int $planteId, int $categorieId): void {
        $this->execute(
            "DELETE FROM plante_categorie WHERE plante_id=? AND categorie_id=?",
            [$planteId, $categorieId]
        );
    }

    public function composants(int $planteId): array {
        return $this->query(
            "SELECT c.*, pc.concentration, pc.notes FROM composants c
             JOIN plante_composant pc ON c.id = pc.composant_id
             WHERE pc.plante_id = ? ORDER BY c.nom",
            [$planteId]
        );
    }

    public function linkComposant(int $planteId, int $composantId, string $concentration = '', string $notes = ''): void {
        $this->execute(
            "INSERT IGNORE INTO plante_composant (plante_id, composant_id, concentration, notes) VALUES (?, ?, ?, ?)",
            [$planteId, $composantId, $concentration, $notes]
        );
    }

    public function unlinkComposant(int $planteId, int $composantId): void {
        $this->execute(
            "DELETE FROM plante_composant WHERE plante_id=? AND composant_id=?",
            [$planteId, $composantId]
        );
    }

    public function vertus(int $planteId): array {
        return $this->query(
            "SELECT v.*, pv.source FROM vertus v
             JOIN plante_vertu pv ON v.id = pv.vertu_id
             WHERE pv.plante_id = ? ORDER BY v.nom",
            [$planteId]
        );
    }

    public function linkVertu(int $planteId, int $vertuId, string $source = ''): void {
        $this->execute(
            "INSERT IGNORE INTO plante_vertu (plante_id, vertu_id, source) VALUES (?, ?, ?)",
            [$planteId, $vertuId, $source]
        );
    }

    public function unlinkVertu(int $planteId, int $vertuId): void {
        $this->execute(
            "DELETE FROM plante_vertu WHERE plante_id=? AND vertu_id=?",
            [$planteId, $vertuId]
        );
    }
}
