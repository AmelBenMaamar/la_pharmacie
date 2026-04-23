<?php
// ================================================
// PlanteController — fiche publique d'une plante
// ================================================

class PlanteController extends Controller {

    public function show(string $slug): void {
        $model  = new Plante();
        $plante = $model->findBySlug($slug);

        if (!$plante || !$plante['actif']) {
            http_response_code(404);
            require APP_ROOT . '/app/views/layouts/404.php';
            return;
        }

        $composants = $model->composants($plante['id']);
        $vertus     = $model->vertus($plante['id']);
        $categories = $model->categories($plante['id']);

        $this->view('plantes/show', compact('plante', 'composants', 'vertus', 'categories'));
    }
}
