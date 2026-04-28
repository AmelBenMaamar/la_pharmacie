<?php
// Config
require_once __DIR__ . '/config/config.php';

// Session
session_name(SESSION_NAME);
session_start();

// Classes core
require_once APP_ROOT . '/core/Database.php';
require_once APP_ROOT . '/core/Model.php';
require_once APP_ROOT . '/core/Controller.php';
require_once APP_ROOT . '/core/Router.php';

// Modèles
require_once APP_ROOT . '/app/models/User.php';
require_once APP_ROOT . '/app/models/Plante.php';
require_once APP_ROOT . '/app/models/Composant.php';
require_once APP_ROOT . '/app/models/Vertu.php';
require_once APP_ROOT . '/app/models/Source.php';

// Contrôleurs
require_once APP_ROOT . '/app/controllers/AuthController.php';
require_once APP_ROOT . '/app/controllers/HomeController.php';
require_once APP_ROOT . '/app/controllers/AdminController.php';
require_once APP_ROOT . '/app/controllers/PlanteController.php';
require_once APP_ROOT . '/app/controllers/ComposantController.php';
require_once APP_ROOT . '/app/controllers/VertusController.php';
require_once APP_ROOT . '/app/controllers/SourceController.php';
require_once APP_ROOT . '/app/controllers/AdminSourceController.php';

// Routes
$router = new Router();
require_once APP_ROOT . '/config/routes.php';

// Dispatch
$router->dispatch();
