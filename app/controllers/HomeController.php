<?php
class HomeController extends Controller {

    public function index(): void {
        $db         = Database::getInstance();
        $plantes    = (new Plante())->all();
        $composants = (new Composant())->all();
        $vertus     = (new Vertu())->all();
        $categories = $db->query('SELECT * FROM categories ORDER BY nom')->fetchAll();
        $user       = $_SESSION['user'] ?? null;
        $this->view('home/index', [
            'plantes'    => $plantes,
            'composants' => $composants,
            'vertus'     => $vertus,
            'categories' => $categories,
            'user'       => $user,
        ]);
    }
}
