<?php
class ComposantController extends Controller {

    public function index(): void {
        $model      = new Composant();
        $composants = $model->all();
        $this->view('composants/index', compact('composants') + ['pageTitle' => 'Composants actifs']);
    }

    public function show(string $slug): void {
        $model     = new Composant();
        $composant = $model->findBySlug($slug);

        if (!$composant || !$composant['actif']) {
            http_response_code(404);
            require APP_ROOT . '/app/views/layouts/404.php';
            return;
        }

        $plantes = $model->plantes($composant['id']);
        $vertus  = $model->vertus($composant['id']);
        $this->view('composants/show', compact('composant', 'plantes', 'vertus') + ['pageTitle' => $composant['nom']]);
    }
}
