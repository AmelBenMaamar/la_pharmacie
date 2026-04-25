<?php
// ================================================
// VertusController — liste + fiche publique d'une vertu
// ================================================

class VertusController extends Controller {

    // Liste toutes les vertus → roue interactive
    public function index(): void {
        $model  = new Vertu();
        $vertus = $model->all('nom', 'ASC');
        $this->view('vertus/index', compact('vertus'));
    }

    public function show(string $slug): void {
        $model = new Vertu();
        $vertu = $model->findBySlug($slug);

        if (!$vertu || !$vertu['actif']) {
            http_response_code(404);
            require APP_ROOT . '/app/views/layouts/404.php';
            return;
        }

        $plantes    = $model->plantes($vertu['id']);
        $composants = $model->composants($vertu['id']);

        $this->view('vertus/show', compact('vertu', 'plantes', 'composants'));
    }
}
