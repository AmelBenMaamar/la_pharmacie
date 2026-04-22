-- ============================================
-- LA PHARMACIE - Schéma MariaDB
-- ============================================

SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    actif TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    couleur VARCHAR(7) DEFAULT '#4a7c59',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS plantes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    nom_latin VARCHAR(150),
    slug VARCHAR(150) NOT NULL UNIQUE,
    description TEXT,
    image VARCHAR(255),
    actif TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS composants (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    famille VARCHAR(100),
    description TEXT,
    actif TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS vertus (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    categorie VARCHAR(100),
    description TEXT,
    actif TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS plante_categorie (
    plante_id INT UNSIGNED NOT NULL,
    categorie_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (plante_id, categorie_id),
    FOREIGN KEY (plante_id) REFERENCES plantes(id) ON DELETE CASCADE,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS plante_composant (
    plante_id INT UNSIGNED NOT NULL,
    composant_id INT UNSIGNED NOT NULL,
    concentration VARCHAR(50),
    notes TEXT,
    PRIMARY KEY (plante_id, composant_id),
    FOREIGN KEY (plante_id) REFERENCES plantes(id) ON DELETE CASCADE,
    FOREIGN KEY (composant_id) REFERENCES composants(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS composant_vertu (
    composant_id INT UNSIGNED NOT NULL,
    vertu_id INT UNSIGNED NOT NULL,
    niveau_evidence ENUM('faible', 'modere', 'fort') DEFAULT 'modere',
    notes TEXT,
    PRIMARY KEY (composant_id, vertu_id),
    FOREIGN KEY (composant_id) REFERENCES composants(id) ON DELETE CASCADE,
    FOREIGN KEY (vertu_id) REFERENCES vertus(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS plante_vertu (
    plante_id INT UNSIGNED NOT NULL,
    vertu_id INT UNSIGNED NOT NULL,
    source VARCHAR(255),
    PRIMARY KEY (plante_id, vertu_id),
    FOREIGN KEY (plante_id) REFERENCES plantes(id) ON DELETE CASCADE,
    FOREIGN KEY (vertu_id) REFERENCES vertus(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO categories (nom, slug, description, couleur) VALUES
('Aromatiques', 'aromatiques', 'Plantes aromatiques et medicinales', '#7c6d4a'),
('Potager', 'potager', 'Legumes et plantes potageres', '#4a7c59'),
('Verger', 'verger', 'Arbres fruitiers et petits fruits', '#7c4a4a'),
('Fleurs', 'fleurs', 'Plantes a fleurs comestibles ou medicinales', '#7c4a6d'),
('Legumineuses', 'legumineuses', 'Legumineuses et plantes fixatrices d azote', '#4a5e7c');

INSERT INTO users (nom, email, password, role) VALUES
('Admin', 'admin@la-pharmacie.fr', '$2y$10$osiAoeKFjZjz3RRRrt9pouTNyJ0s6OKGet8.frrW2q1xOqvk57Cwq', 'admin');

SET FOREIGN_KEY_CHECKS = 1;
