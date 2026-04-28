<?php
// ================================================
// Source — modèle
// ================================================
// Gère les sources bibliographiques et leurs liaisons avec :
//   - les composants  (composant_source)
//   - les vertus      (vertu_source)

class Source extends Model {
    protected string $table = 'sources';

    // Liste toutes les sources actives
    public function all(string $orderBy = 'annee', string $dir = 'DESC'): array {
        return $this->query(
            "SELECT * FROM sources WHERE actif = 1 ORDER BY {$orderBy} {$dir}"
        );
    }

    // Compte par type (pour stats dashboard)
    public function countByType(): array {
        return $this->query(
            "SELECT type_source, COUNT(*) AS nb FROM sources WHERE actif = 1 GROUP BY type_source ORDER BY nb DESC"
        );
    }

    // Trouve par id
    public function find(int $id): ?array {
        $rows = $this->query("SELECT * FROM sources WHERE id = ?", [$id]);
        return $rows[0] ?? null;
    }

    // Crée une nouvelle source
    public function create(array $data): int {
        $this->execute(
            "INSERT INTO sources (titre, auteurs, journal, annee, url, doi, resume, type_source, actif)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                trim($data['titre']),
                trim($data['auteurs']     ?? ''),
                trim($data['journal']     ?? ''),
                !empty($data['annee']) ? (int)$data['annee'] : null,
                trim($data['url']         ?? ''),
                trim($data['doi']         ?? ''),
                trim($data['resume']      ?? ''),
                $data['type_source']      ?? 'etude',
                $data['actif']            ?? 1,
            ]
        );
        return $this->lastInsertId();
    }

    // Met à jour une source
    public function update(int $id, array $data): void {
        $this->execute(
            "UPDATE sources
             SET titre=?, auteurs=?, journal=?, annee=?, url=?, doi=?, resume=?, type_source=?, actif=?
             WHERE id=?",
            [
                trim($data['titre']),
                trim($data['auteurs']     ?? ''),
                trim($data['journal']     ?? ''),
                !empty($data['annee']) ? (int)$data['annee'] : null,
                trim($data['url']         ?? ''),
                trim($data['doi']         ?? ''),
                trim($data['resume']      ?? ''),
                $data['type_source']      ?? 'etude',
                $data['actif']            ?? 1,
                $id,
            ]
        );
    }

    // Supprime (soft delete via actif=0)
    public function delete(int $id): void {
        $this->execute("UPDATE sources SET actif = 0 WHERE id = ?", [$id]);
    }

    // ------------------------------------------------
    // Liaisons — Composants
    // ------------------------------------------------

    public function composants(int $sourceId): array {
        return $this->query(
            "SELECT c.*, cs.notes FROM composants c
             JOIN composant_source cs ON c.id = cs.composant_id
             WHERE cs.source_id = ? AND c.actif = 1
             ORDER BY c.nom",
            [$sourceId]
        );
    }

    public function linkComposant(int $sourceId, int $composantId, string $notes = ''): void {
        $this->execute(
            "INSERT IGNORE INTO composant_source (composant_id, source_id, notes) VALUES (?, ?, ?)",
            [$composantId, $sourceId, $notes]
        );
    }

    public function unlinkComposant(int $sourceId, int $composantId): void {
        $this->execute(
            "DELETE FROM composant_source WHERE composant_id = ? AND source_id = ?",
            [$composantId, $sourceId]
        );
    }

    // ------------------------------------------------
    // Liaisons — Vertus
    // ------------------------------------------------

    public function vertus(int $sourceId): array {
        return $this->query(
            "SELECT v.*, vs.notes FROM vertus v
             JOIN vertu_source vs ON v.id = vs.vertu_id
             WHERE vs.source_id = ? AND v.actif = 1
             ORDER BY v.nom",
            [$sourceId]
        );
    }

    public function linkVertu(int $sourceId, int $vertuId, string $notes = ''): void {
        $this->execute(
            "INSERT IGNORE INTO vertu_source (vertu_id, source_id, notes) VALUES (?, ?, ?)",
            [$vertuId, $sourceId, $notes]
        );
    }

    public function unlinkVertu(int $sourceId, int $vertuId): void {
        $this->execute(
            "DELETE FROM vertu_source WHERE vertu_id = ? AND source_id = ?",
            [$vertuId, $sourceId]
        );
    }

    // ------------------------------------------------
    // Requêtes inverses (depuis composant ou vertu)
    // ------------------------------------------------

    // Sources liées à un composant donné
    public function ofComposant(int $composantId): array {
        return $this->query(
            "SELECT s.*, cs.notes FROM sources s
             JOIN composant_source cs ON s.id = cs.source_id
             WHERE cs.composant_id = ? AND s.actif = 1
             ORDER BY s.annee DESC",
            [$composantId]
        );
    }

    // Sources liées à une vertu donnée
    public function ofVertu(int $vertuId): array {
        return $this->query(
            "SELECT s.*, vs.notes FROM sources s
             JOIN vertu_source vs ON s.id = vs.source_id
             WHERE vs.vertu_id = ? AND s.actif = 1
             ORDER BY s.annee DESC",
            [$vertuId]
        );
    }
}
