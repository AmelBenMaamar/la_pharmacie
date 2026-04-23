<?php
// ================================================
// Routes de l'application
// ================================================
// Format : $router->get('url', 'Controller', 'methode')
// Les {slug} et {id} sont capturés automatiquement
// et passés en paramètre à la méthode.

// ------------------------------------------------
// Authentification
// ------------------------------------------------
$router->get( '/login',    'AuthController', 'loginForm');
$router->post('/login',    'AuthController', 'login');
$router->get( '/logout',   'AuthController', 'logout');

// ------------------------------------------------
// Home (page d'accueil publique)
// ------------------------------------------------
$router->get('/', 'HomeController', 'index');

// ------------------------------------------------
// ADMIN — Dashboard
// ------------------------------------------------
$router->get('/admin', 'AdminController', 'dashboard');

// ------------------------------------------------
// ADMIN — Plantes
// ------------------------------------------------
$router->get( '/admin/plantes',                'AdminController', 'plantes');
$router->get( '/admin/plantes/creer',          'AdminController', 'planteCreer');
$router->post('/admin/plantes/creer',          'AdminController', 'planteStorer');
$router->get( '/admin/plantes/{id}/editer',    'AdminController', 'planteEditer');
$router->post('/admin/plantes/{id}/editer',    'AdminController', 'planteUpdater');
$router->post('/admin/plantes/{id}/supprimer', 'AdminController', 'planteSupprimer');
$router->get( '/admin/plantes/{id}/liens',     'AdminController', 'planteLiens');
$router->post('/admin/plantes/{id}/liens',     'AdminController', 'planteLiensStorer');
$router->post('/admin/plantes/{id}/liens/supprimer', 'AdminController', 'planteLiensSupprimer');

// ------------------------------------------------
// ADMIN — Composants
// ------------------------------------------------
$router->get( '/admin/composants',                'AdminController', 'composants');
$router->get( '/admin/composants/creer',          'AdminController', 'composantCreer');
$router->post('/admin/composants/creer',          'AdminController', 'composantStorer');
$router->get( '/admin/composants/{id}/editer',    'AdminController', 'composantEditer');
$router->post('/admin/composants/{id}/editer',    'AdminController', 'composantUpdater');
$router->post('/admin/composants/{id}/supprimer', 'AdminController', 'composantSupprimer');

// ------------------------------------------------
// ADMIN — Vertus
// ------------------------------------------------
$router->get( '/admin/vertus',                'AdminController', 'vertus');
$router->get( '/admin/vertus/creer',          'AdminController', 'vertuCreer');
$router->post('/admin/vertus/creer',          'AdminController', 'vertuStorer');
$router->get( '/admin/vertus/{id}/editer',    'AdminController', 'vertuEditer');
$router->post('/admin/vertus/{id}/editer',    'AdminController', 'vertuUpdater');
$router->post('/admin/vertus/{id}/supprimer', 'AdminController', 'vertuSupprimer');

// ------------------------------------------------
// ADMIN — Catégories
// ------------------------------------------------
$router->get( '/admin/categories',                'AdminController', 'categories');
$router->get( '/admin/categories/creer',          'AdminController', 'categorieCreer');
$router->post('/admin/categories/creer',          'AdminController', 'categorieStorer');
$router->get( '/admin/categories/{id}/editer',    'AdminController', 'categorieEditer');
$router->post('/admin/categories/{id}/editer',    'AdminController', 'categorieUpdater');
$router->post('/admin/categories/{id}/supprimer', 'AdminController', 'categorieSupprimer');

// ------------------------------------------------
// PUBLIC — Fiches
// ------------------------------------------------
$router->get('/plantes/{slug}',    'PlanteController',    'show');
$router->get('/composants/{slug}', 'ComposantController', 'show');
$router->get('/vertus/{slug}',     'VertusController',    'show');
