<?php
// ================================================
// Chargement du .env
// ================================================
// On lit le fichier .env ligne par ligne et on
// définit chaque variable comme constante PHP.
// C'est notre système simple sans dépendance externe.

$envFile = dirname(__DIR__) . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

// ================================================
// Constantes application
// ================================================
define('APP_NAME',  $_ENV['APP_NAME']  ?? 'La Pharmacie');
define('APP_ENV',   $_ENV['APP_ENV']   ?? 'local');
define('APP_URL',   $_ENV['APP_URL']   ?? 'http://localhost/la_pharmacie/public');
define('APP_ROOT',  dirname(__DIR__));

// ================================================
// Constantes base de données
// ================================================
define('DB_HOST', $_ENV['DB_HOST'] ?? '127.0.0.1');
define('DB_PORT', $_ENV['DB_PORT'] ?? '3306');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'la_pharmacie');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');

// ================================================
// Session
// ================================================
define('SESSION_NAME', $_ENV['SESSION_NAME'] ?? 'lapharmacie_session');

// ================================================
// Upload
// ================================================
define('UPLOAD_DIR',      APP_ROOT . '/public/uploads/');
define('UPLOAD_MAX_SIZE', 5 * 1024 * 1024); // 5 Mo
define('UPLOAD_TYPES',    ['image/jpeg', 'image/png', 'image/webp']);

// ================================================
// Erreurs (désactivées en prod)
// ================================================
if (APP_ENV === 'local') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}
