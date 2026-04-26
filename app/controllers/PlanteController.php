<?php
class PlanteController extends Controller {

    public function index(): void {
        $model   = new Plante();
        $plantes = $model->all();
        $this->view('plantes/index', compact('plantes') + ['pageTitle' => 'Plantes']);
    }

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

        $liens_cv = $model->liensComposantVertu($plante['id']);
        $this->view('plantes/show', compact('plante', 'composants', 'vertus', 'categories', 'liens_cv') + ['pageTitle' => $plante['nom']]);
    }
}
