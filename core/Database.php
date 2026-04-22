<?php
// ================================================
// Database — connexion PDO Singleton
// ================================================
// Une seule connexion est créée et partagée dans
// toute l'application. PDO est plus sécurisé que
// mysqli : requêtes préparées, gestion d'erreurs.

class Database {
    private static ?PDO $instance = null;

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                DB_HOST, DB_PORT, DB_NAME
            );
            self::$instance = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }
        return self::$instance;
    }

    // Empêche la création directe et la copie
    private function __construct() {}
    private function __clone() {}
}
