<?php
// ================================================
// SourceController — pages publiques des sources
// ================================================

class SourceController extends Controller {

    // Liste toutes les sources
    public function index(): void {
        $model   = new Source();
        $sources = $model->all();
        // Regroupe par type pour l'affichage
        $parType = [];
        foreach ($sources as $s) {
            $parType[$s['type_source']][] = $s;
        }
        $this->view('sources/index', [
            'sources'   => $sources,
            'parType'   => $parType,
            'pageTitle' => 'Sources & Études',
        ]);
    }

    // Fiche d'une source
    public function show(string $id): void {
        $model  = new Source();
        $source = $model->find((int)$id);

        if (!$source || !$source['actif']) {
            http_response_code(404);
            require APP_ROOT . '/app/views/layouts/404.php';
            return;
        }

        $composants = $model->composants($source['id']);
        $vertus     = $model->vertus($source['id']);

        $this->view('sources/show', [
            'source'     => $source,
            'composants' => $composants,
            'vertus'     => $vertus,
            'pageTitle'  => $source['titre'],
        ]);
    }
}
