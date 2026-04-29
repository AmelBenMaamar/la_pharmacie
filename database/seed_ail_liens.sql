-- ============================================================
-- SEED AIL — Partie 2 : liens plante_composant + plante_vertu
-- Syntaxe MariaDB 10.11 (pas de VALUES ROW)
-- ============================================================

SET NAMES utf8mb4;

-- ── plante_composant : lier les composants à ail-cultive ────

INSERT IGNORE INTO plante_composant (plante_id, composant_id, concentration, notes)
SELECT p.id, c.id, '1,235 mg/100g', 'CIQUAL 2020 / USDA — AJR 88%'
FROM plantes p JOIN composants c ON c.slug = 'vitamine-b6'  WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, c.id, '0,200 mg/100g', 'CIQUAL 2020 — AJR 18%'
FROM plantes p JOIN composants c ON c.slug = 'vitamine-b1'  WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, c.id, '3,0 µg/100g', 'CIQUAL 2020 — teneur modeste, AJR 1,5%'
FROM plantes p JOIN composants c ON c.slug = 'vitamine-b9'  WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, c.id, '31,2 mg/100g', 'CIQUAL 2020 — AJR 39%, variable selon fraicheur'
FROM plantes p JOIN composants c ON c.slug = 'vitamine-c'   WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, c.id, '1,672 mg/100g', 'USDA FoodData Central — AJR 73%'
FROM plantes p JOIN composants c ON c.slug = 'manganese'    WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, c.id, '0,299 mg/100g', 'USDA FoodData Central — AJR 30%'
FROM plantes p JOIN composants c ON c.slug = 'cuivre'       WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, c.id, '401 mg/100g', 'CIQUAL 2020 — AJR 20%'
FROM plantes p JOIN composants c ON c.slug = 'potassium'    WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, c.id, '1,160 mg/100g', 'USDA FoodData Central — AJR 12%'
FROM plantes p JOIN composants c ON c.slug = 'zinc'         WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, c.id, '14,2 µg/100g', 'USDA FoodData Central — AJR 26%'
FROM plantes p JOIN composants c ON c.slug = 'selenium'     WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, c.id, '~47 mg/100g', 'PMC9650110 — flavonoides totaux'
FROM plantes p JOIN composants c ON c.slug = 'quercetine'   WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, c.id, '~72 mg/100g', 'PMC9650110 — polyphenols totaux estimes'
FROM plantes p JOIN composants c ON c.slug = 'les-polyphenols' WHERE p.slug = 'ail-cultive';

-- ── plante_vertu : vertus globales de l'ail ─────────────────

INSERT IGNORE INTO plante_vertu (plante_id, vertu_id, source)
SELECT p.id, v.id, 'OMS Monographs Vol.1 1999 / Cavallito & Bailey 1944'
FROM plantes p JOIN vertus v ON v.slug = 'antibacterien' WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, v.id, 'OMS Monographs Vol.1 1999'
FROM plantes p JOIN vertus v ON v.slug = 'antifongique' WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, v.id, 'Behrouz et al. 2025 — Nutrition Reviews doi:10.1093/nutrit/nuaf090'
FROM plantes p JOIN vertus v ON v.slug = 'cardioprotecteur' WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, v.id, 'Behrouz et al. 2025 — amelioration glycemie et insulino-resistance'
FROM plantes p JOIN vertus v ON v.slug = 'hypoglycemiant' WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, v.id, 'PMC9650110 — proprietes antiproliferatives in vitro'
FROM plantes p JOIN vertus v ON v.slug = 'anticancereux-preventif' WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, v.id, 'PMC9650110 / Nutripure — quercetine et polyphenols'
FROM plantes p JOIN vertus v ON v.slug = 'antioxydant' WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, v.id, 'Behrouz et al. 2025 — reduction marqueurs inflammatoires'
FROM plantes p JOIN vertus v ON v.slug = 'anti-inflammatoire' WHERE p.slug = 'ail-cultive'
UNION ALL
SELECT p.id, v.id, 'OMS — usage traditionnel reconnu, infections respiratoires et digestives'
FROM plantes p JOIN vertus v ON v.slug = 'immunostimulant' WHERE p.slug = 'ail-cultive';

