<?php
// ================================================
// VertusController — fiche publique d'une vertu
// ================================================

class VertusController extends Controller {

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
