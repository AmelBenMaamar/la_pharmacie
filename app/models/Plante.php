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

    /**
     * Liens composant->vertu pour une plante donnee
     * Utilise par le graphe interactif (show.php)
     */
    public function liensComposantVertu(int $planteId): array {
        $sql = "SELECT c.slug AS composant_slug, v.slug AS vertu_slug
                FROM composant_vertu cv
                JOIN composants c ON c.id = cv.composant_id
                JOIN vertus     v ON v.id = cv.vertu_id
                JOIN plante_composant pc ON pc.composant_id = cv.composant_id
                WHERE pc.plante_id = :plante_id";
        return $this->query($sql, ['plante_id' => $planteId]);
    }

    /** Vertus liées à un composant donné */
    public function vertusDeComposant(int $composantId): array {
        return $this->query(
            "SELECT v.*, cv.niveau_evidence FROM vertus v
             JOIN composant_vertu cv ON cv.vertu_id = v.id
             WHERE cv.composant_id = :cid ORDER BY v.nom",
            ['cid' => $composantId]
        );
    }

    /** Lier un composant à une vertu */
    public function linkComposantVertu(int $composantId, int $vertuId, string $niveau = 'modere'): void {
        $this->execute(
            "INSERT IGNORE INTO composant_vertu (composant_id, vertu_id, niveau_evidence)
             VALUES (?, ?, ?)",
            [$composantId, $vertuId, $niveau]
        );
    }

    /** Délier un composant d'une vertu */
    public function unlinkComposantVertu(int $composantId, int $vertuId): void {
        $this->execute(
            "DELETE FROM composant_vertu WHERE composant_id=? AND vertu_id=?",
            [$composantId, $vertuId]
        );
    }

}