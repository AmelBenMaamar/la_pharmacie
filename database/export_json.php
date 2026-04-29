<?php
$pdo = new PDO(
    "mysql:host=127.0.0.1;dbname=la_pharmacie;charset=utf8mb4",
    'pharmacie', 'pharmacie2024'
);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$export = [];

foreach (['plantes','composants','vertus','categories'] as $table) {
    $export[$table] = $pdo->query("SELECT * FROM $table ORDER BY id")->fetchAll();
}

try {
    $export['sources'] = $pdo->query("SELECT * FROM sources ORDER BY id")->fetchAll();
} catch (Exception $e) {
    $export['sources'] = [];
}

$export['plante_composant'] = $pdo->query("
    SELECT p.slug AS plante_slug, c.slug AS composant_slug,
           pc.concentration, pc.notes
    FROM plante_composant pc
    JOIN plantes    p ON p.id = pc.plante_id
    JOIN composants c ON c.id = pc.composant_id
    ORDER BY p.slug, c.slug
")->fetchAll();

$export['composant_vertu'] = $pdo->query("
    SELECT c.slug AS composant_slug, v.slug AS vertu_slug,
           cv.niveau_evidence, cv.notes
    FROM composant_vertu cv
    JOIN composants c ON c.id = cv.composant_id
    JOIN vertus     v ON v.id = cv.vertu_id
    ORDER BY c.slug, v.slug
")->fetchAll();

$export['plante_vertu'] = $pdo->query("
    SELECT p.slug AS plante_slug, v.slug AS vertu_slug, pv.source
    FROM plante_vertu pv
    JOIN plantes p ON p.id = pv.plante_id
    JOIN vertus  v ON v.id = pv.vertu_id
    ORDER BY p.slug, v.slug
")->fetchAll();

$filename = __DIR__ . '/../pharmacie_export_' . date('Ymd') . '.json';
file_put_contents($filename, json_encode($export, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "Export genere : " . $filename . "\n";
foreach ($export as $table => $rows) {
    echo "  " . $table . " : " . count($rows) . " entrees\n";
}
