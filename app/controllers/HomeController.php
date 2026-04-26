<?php
class HomeController extends Controller {
    public function index(): void {
        $db         = Database::getInstance();
        $plantes    = (new Plante())->all();
        $composants = (new Composant())->all();
        $vertus     = (new Vertu())->all();
        $categories = $db->query('SELECT * FROM categories ORDER BY nom')->fetchAll();
        $user       = $_SESSION['user'] ?? null;

        // ── Fix N+1 : une seule requête pour toutes les catégories de toutes les plantes
        $stmt = $db->query(
            "SELECT pc.plante_id, c.nom, c.couleur
             FROM plante_categorie pc
             JOIN categories c ON c.id = pc.categorie_id
             ORDER BY c.nom"
        );
        $cats_par_plante = [];
        foreach ($stmt->fetchAll() as $row) {
            $cats_par_plante[$row['plante_id']][] = [
                'nom'    => $row['nom'],
                'couleur'=> $row['couleur'],
            ];
        }

        $this->view('home/index', [
            'plantes'         => $plantes,
            'composants'      => $composants,
            'vertus'          => $vertus,
            'categories'      => $categories,
            'cats_par_plante' => $cats_par_plante,
            'user'            => $user,
            'pageTitle'       => 'Accueil',
        ]);
    }
}
