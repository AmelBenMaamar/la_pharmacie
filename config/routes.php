<?php
// ================================================
// Routes de l'application
// ================================================

// Authentification
$router->get( '/login',    'AuthController', 'loginForm');
$router->post('/login',    'AuthController', 'login');
$router->get( '/logout',   'AuthController', 'logout');

// Home
$router->get('/', 'HomeController', 'index');

// ADMIN — Dashboard
$router->get('/admin', 'AdminController', 'dashboard');

// ADMIN — Plantes
$router->get( '/admin/plantes',                'AdminController', 'plantes');
$router->get( '/admin/plantes/creer',          'AdminController', 'planteCreer');
$router->post('/admin/plantes/creer',          'AdminController', 'planteStorer');
$router->get( '/admin/plantes/{id}/editer',    'AdminController', 'planteEditer');
$router->post('/admin/plantes/{id}/editer',    'AdminController', 'planteUpdater');
$router->post('/admin/plantes/{id}/supprimer', 'AdminController', 'planteSupprimer');
$router->get( '/admin/plantes/{id}/liens',     'AdminController', 'planteLiens');
$router->post('/admin/plantes/{id}/liens',     'AdminController', 'planteLiensStorer');
$router->post('/admin/plantes/{id}/liens/supprimer', 'AdminController', 'planteLiensSupprimer');

// ADMIN — Composants
$router->get( '/admin/composants',                    'AdminController', 'composants');
$router->get( '/admin/composants/creer',              'AdminController', 'composantCreer');
$router->post('/admin/composants/creer',              'AdminController', 'composantStorer');
$router->get( '/admin/composants/{id}/editer',        'AdminController', 'composantEditer');
$router->post('/admin/composants/{id}/editer',        'AdminController', 'composantUpdater');
$router->post('/admin/composants/{id}/supprimer',     'AdminController', 'composantSupprimer');
$router->get( '/admin/composants/{id}/vertus',        'AdminController', 'composantVertus');
$router->post('/admin/composants/{id}/vertus/bulk',   'AdminController', 'composantVertusStorer');

// ADMIN — Vertus
$router->get( '/admin/vertus',                       'AdminController', 'vertus');
$router->get( '/admin/vertus/creer',                 'AdminController', 'vertuCreer');
$router->post('/admin/vertus/creer',                 'AdminController', 'vertuStorer');
$router->get( '/admin/vertus/{id}/editer',           'AdminController', 'vertuEditer');
$router->post('/admin/vertus/{id}/editer',           'AdminController', 'vertuUpdater');
$router->post('/admin/vertus/{id}/supprimer',        'AdminController', 'vertuSupprimer');
$router->get( '/admin/vertus/{id}/composants',       'AdminController', 'vertuComposants');
$router->post('/admin/vertus/{id}/composants/bulk',  'AdminController', 'vertuComposantsStorer');

// ADMIN — Catégories
$router->get( '/admin/categories',                'AdminController', 'categories');
$router->get( '/admin/categories/creer',          'AdminController', 'categorieCreer');
$router->post('/admin/categories/creer',          'AdminController', 'categorieStorer');
$router->get( '/admin/categories/{id}/editer',    'AdminController', 'categorieEditer');
$router->post('/admin/categories/{id}/editer',    'AdminController', 'categorieUpdater');
$router->post('/admin/categories/{id}/supprimer', 'AdminController', 'categorieSupprimer');

// PUBLIC — Liste (routes fixes AVANT les routes à paramètre)
$router->get('/plantes',    'PlanteController',    'index');
$router->get('/composants', 'ComposantController', 'index');
$router->get('/vertus',     'VertusController',    'index');

// PUBLIC — Fiches (routes à paramètre EN DERNIER)
$router->get('/plantes/{slug}',    'PlanteController',    'show');
$router->get('/composants/{slug}', 'ComposantController', 'show');
$router->get('/vertus/{slug}',     'VertusController',    'show');

// ADMIN — Liens bulk
$router->post('/admin/plantes/{id}/liens/bulk', 'AdminController', 'planteLiensBulk');

// PUBLIC — Sources
$router->get('/sources',      'SourceController', 'index');
$router->get('/sources/{id}', 'SourceController', 'show');

// ADMIN — Sources
$router->get( '/admin/sources',                      'AdminSourceController', 'index');
$router->get( '/admin/sources/creer',                'AdminSourceController', 'creer');
$router->post('/admin/sources/creer',                'AdminSourceController', 'storer');
$router->get( '/admin/sources/{id}/editer',          'AdminSourceController', 'editer');
$router->post('/admin/sources/{id}/editer',          'AdminSourceController', 'updater');
$router->post('/admin/sources/{id}/supprimer',       'AdminSourceController', 'supprimer');
$router->get( '/admin/sources/{id}/liens',           'AdminSourceController', 'liens');
$router->post('/admin/sources/{id}/liens',           'AdminSourceController', 'liensStorer');
$router->post('/admin/sources/{id}/liens/supprimer', 'AdminSourceController', 'liensSupprimer');
