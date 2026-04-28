<?php
// ================================================
// AdminSourceController — CRUD sources + liaisons
// ================================================

class AdminSourceController extends Controller {

    // ------------------------------------------------
    // Liste
    // ------------------------------------------------
    public function index(): void {
        $this->requireAdmin();
        $db = Database::getInstance();
        $sources = $db->query(
            "SELECT s.*,
                    COUNT(DISTINCT cs.composant_id) AS nb_composants,
                    COUNT(DISTINCT vs.vertu_id)     AS nb_vertus
             FROM sources s
             LEFT JOIN composant_source cs ON cs.source_id = s.id
             LEFT JOIN vertu_source     vs ON vs.source_id = s.id
             WHERE s.actif = 1
             GROUP BY s.id
             ORDER BY s.annee DESC, s.titre ASC"
        )->fetchAll();

        $this->view('admin/sources', [
            'sources' => $sources,
            'user'    => $_SESSION['user'],
        ]);
    }

    // ------------------------------------------------
    // Créer
    // ------------------------------------------------
    public function creer(): void {
        $this->requireAdmin();
        $this->view('admin/source_form', [
            'source' => null,
            'user'   => $_SESSION['user'],
            'token'  => $this->csrfToken(),
        ]);
    }

    public function storer(): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        $id = (new Source())->create($_POST);
        $this->flash('success', 'Source créée avec succès.');
        $this->redirect('/admin/sources/' . $id . '/liens');
    }

    // ------------------------------------------------
    // Éditer
    // ------------------------------------------------
    public function editer(string $id): void {
        $this->requireAdmin();
        $source = (new Source())->find((int)$id);
        if (!$source) { http_response_code(404); echo 'Source introuvable'; return; }
        $this->view('admin/source_form', [
            'source' => $source,
            'user'   => $_SESSION['user'],
            'token'  => $this->csrfToken(),
        ]);
    }

    public function updater(string $id): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        (new Source())->update((int)$id, $_POST);
        $this->flash('success', 'Source mise à jour.');
        $this->redirect('/admin/sources');
    }

    // ------------------------------------------------
    // Supprimer
    // ------------------------------------------------
    public function supprimer(string $id): void {
        $this->requireAdmin();
        (new Source())->delete((int)$id);
        $this->flash('success', 'Source supprimée.');
        $this->redirect('/admin/sources');
    }

    // ------------------------------------------------
    // Liaisons composants + vertus
    // ------------------------------------------------
    public function liens(string $id): void {
        $this->requireAdmin();
        $model  = new Source();
        $source = $model->find((int)$id);
        if (!$source) { http_response_code(404); echo 'Source introuvable'; return; }

        $composants_lies = $model->composants($source['id']);
        $vertus_liees    = $model->vertus($source['id']);
        $all_composants  = (new Composant())->all();
        $all_vertus      = (new Vertu())->all();

        $this->view('admin/source_liens', [
            'source'          => $source,
            'composants_lies' => $composants_lies,
            'vertus_liees'    => $vertus_liees,
            'all_composants'  => $all_composants,
            'all_vertus'      => $all_vertus,
            'user'            => $_SESSION['user'],
            'token'           => $this->csrfToken(),
        ]);
    }

    public function liensStorer(string $id): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        $model    = new Source();
        $sourceId = (int)$id;
        $type     = $_POST['type'] ?? '';

        if ($type === 'composant') {
            $model->linkComposant($sourceId, (int)$_POST['composant_id'], trim($_POST['notes'] ?? ''));
        } elseif ($type === 'vertu') {
            $model->linkVertu($sourceId, (int)$_POST['vertu_id'], trim($_POST['notes'] ?? ''));
        }

        $this->flash('success', 'Lien ajouté.');
        $this->redirect('/admin/sources/' . $sourceId . '/liens');
    }

    public function liensSupprimer(string $id): void {
        $this->requireAdmin();
        $model    = new Source();
        $sourceId = (int)$id;
        $type     = $_POST['type'] ?? '';

        if ($type === 'composant') {
            $model->unlinkComposant($sourceId, (int)$_POST['composant_id']);
        } elseif ($type === 'vertu') {
            $model->unlinkVertu($sourceId, (int)$_POST['vertu_id']);
        }

        $this->flash('success', 'Lien supprimé.');
        $this->redirect('/admin/sources/' . $sourceId . '/liens');
    }
}
