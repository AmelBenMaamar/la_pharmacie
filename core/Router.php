<?php
// ================================================
// Router — dispatch les URLs vers les contrôleurs
// ================================================
// On enregistre des routes GET et POST.
// Pour chaque requête, on cherche la route qui
// correspond à l'URL et on appelle le bon
// contrôleur + la bonne méthode.
// Les segments {id} ou {slug} sont capturés
// automatiquement et passés en paramètre.

class Router {
    private array $routes = [];

    // Enregistre une route GET
    public function get(string $path, string $controller, string $method): void {
        $this->routes['GET'][$path] = [$controller, $method];
    }

    // Enregistre une route POST
    public function post(string $path, string $controller, string $method): void {
        $this->routes['POST'][$path] = [$controller, $method];
    }

    // Dispatch : trouve la route et appelle le contrôleur
    public function dispatch(): void {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri        = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Retire le sous-dossier du chemin (ex: /la_pharmacie/public)
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $path = '/' . ltrim(substr($uri, strlen($base)), '/');
        if ($path === '') $path = '/';

        foreach ($this->routes[$httpMethod] ?? [] as $route => $handler) {
            // Transforme {slug} en groupe de capture regex
            $pattern = preg_replace('#\{[^}]+\}#', '([^/]+)', $route);
            if (preg_match('#^' . $pattern . '$#', $path, $matches)) {
                array_shift($matches); // retire le match complet
                [$controller, $action] = $handler;
                require_once APP_ROOT . '/app/controllers/' . $controller . '.php';
                $obj = new $controller();
                $obj->$action(...$matches);
                return;
            }
        }

        // Aucune route trouvée → 404
        http_response_code(404);
        require APP_ROOT . '/app/views/layouts/404.php';
    }
}
