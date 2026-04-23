<?php
// ================================================
// ComposantController — fiche publique d'un composant
// ================================================

class ComposantController extends Controller {

    public function show(string $slug): void {
        $model    = new Composant();
        $composant = $model->findBySlug($slug);

        if (!$composant || !$composant['actif']) {
            http_response_code(404);
            require APP_ROOT . '/app/views/layouts/404.php';
            return;
        }

        $plantes = $model->plantes($composant['id']);
        $vertus  = $model->vertus($composant['id']);

        $this->view('composants/show', compact('composant', 'plantes', 'vertus'));
    }
}
