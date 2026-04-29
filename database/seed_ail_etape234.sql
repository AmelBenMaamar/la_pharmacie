-- ============================================================
-- ÉTAPES 2, 3, 4 — Liaisons sources pour l'ail
-- IDs sources : CIQUAL=1, WHO=7, Allicin=9, Vidal=13,
--               Cavallito=14, Behrouz=15, USDA=16, PMC=17
-- ============================================================
SET NAMES utf8mb4;

-- ════════════════════════════════════════════════════════════
-- ÉTAPE 2 — Corriger 3 liens composant_source erronés
-- Beta-glucans (id=2) est une source sur l'avoine,
-- pas sur potassium/vitamine-c/polyphénols
-- ════════════════════════════════════════════════════════════

DELETE FROM composant_source
WHERE source_id = 2
AND composant_id IN (
    SELECT id FROM composants
    WHERE slug IN ('potassium', 'vitamine-c', 'les-polyphenols')
);

-- ════════════════════════════════════════════════════════════
-- ÉTAPE 3 — Ajouter composant_source pour tous les composants
-- de l'ail qui n'ont pas encore de source correcte
-- Source nutritionnelle : CIQUAL (1) + USDA (16)
-- Source phytochimique  : PMC9650110 (17)
-- ════════════════════════════════════════════════════════════

INSERT IGNORE INTO composant_source (composant_id, source_id, notes)

-- vitamine-b6 → CIQUAL + USDA
SELECT c.id, 1,  'Teneur ail cru : 1,235 mg/100g — AJR 88%'
FROM composants c WHERE c.slug = 'vitamine-b6'
UNION ALL
SELECT c.id, 16, 'FoodData Central #169230 — vitamine B6 ail cru'
FROM composants c WHERE c.slug = 'vitamine-b6'

-- vitamine-b1 → CIQUAL + USDA
UNION ALL
SELECT c.id, 1,  'Teneur ail cru : 0,200 mg/100g — AJR 18%'
FROM composants c WHERE c.slug = 'vitamine-b1'
UNION ALL
SELECT c.id, 16, 'FoodData Central #169230 — vitamine B1 ail cru'
FROM composants c WHERE c.slug = 'vitamine-b1'

-- vitamine-b9 → CIQUAL + USDA
UNION ALL
SELECT c.id, 1,  'Teneur ail cru : 3,0 µg/100g — teneur modeste'
FROM composants c WHERE c.slug = 'vitamine-b9'
UNION ALL
SELECT c.id, 16, 'FoodData Central #169230 — folate ail cru'
FROM composants c WHERE c.slug = 'vitamine-b9'

-- vitamine-c → CIQUAL (lien Beta-glucans supprimé, on remet CIQUAL proprement)
UNION ALL
SELECT c.id, 1,  'Teneur ail cru : 31,2 mg/100g — AJR 39%'
FROM composants c WHERE c.slug = 'vitamine-c'

-- manganese → USDA
UNION ALL
SELECT c.id, 16, 'FoodData Central #169230 — manganèse ail cru : 1,672 mg/100g — AJR 73%'
FROM composants c WHERE c.slug = 'manganese'
UNION ALL
SELECT c.id, 1,  'Table CIQUAL — manganèse ail cru'
FROM composants c WHERE c.slug = 'manganese'

-- cuivre → USDA
UNION ALL
SELECT c.id, 16, 'FoodData Central #169230 — cuivre ail cru : 0,299 mg/100g — AJR 30%'
FROM composants c WHERE c.slug = 'cuivre'
UNION ALL
SELECT c.id, 1,  'Table CIQUAL — cuivre ail cru'
FROM composants c WHERE c.slug = 'cuivre'

-- potassium → CIQUAL (lien Beta-glucans supprimé)
UNION ALL
SELECT c.id, 1,  'Teneur ail cru : 401 mg/100g — AJR 20%'
FROM composants c WHERE c.slug = 'potassium'

-- zinc → USDA
UNION ALL
SELECT c.id, 16, 'FoodData Central #169230 — zinc ail cru : 1,160 mg/100g — AJR 12%'
FROM composants c WHERE c.slug = 'zinc'
UNION ALL
SELECT c.id, 1,  'Table CIQUAL — zinc ail cru'
FROM composants c WHERE c.slug = 'zinc'

-- selenium → USDA
UNION ALL
SELECT c.id, 16, 'FoodData Central #169230 — sélénium ail cru : 14,2 µg/100g — AJR 26%'
FROM composants c WHERE c.slug = 'selenium'
UNION ALL
SELECT c.id, 1,  'Table CIQUAL — sélénium ail cru'
FROM composants c WHERE c.slug = 'selenium'

-- les-polyphenols → PMC (lien Beta-glucans supprimé)
UNION ALL
SELECT c.id, 17, 'PMC9650110 — polyphénols totaux ail : ~72 mg/100g estimés'
FROM composants c WHERE c.slug = 'les-polyphenols'

-- quercetine → PMC (déjà ESCOP+Quercetin, on ajoute PMC)
UNION ALL
SELECT c.id, 17, 'PMC9650110 — flavonoïdes ail dont quercétine : ~47 mg/100g'
FROM composants c WHERE c.slug = 'quercetine'

-- allicine → Vidal + Cavallito (déjà WHO+Allicin, on complète)
UNION ALL
SELECT c.id, 13, 'Vidal.fr — mécanisme alliine/allicine, instabilité chaleur, délai 10 min'
FROM composants c WHERE c.slug = 'allicine'
UNION ALL
SELECT c.id, 14, 'Première isolation allicine 1944 — propriétés antibactériennes'
FROM composants c WHERE c.slug = 'allicine';

-- ════════════════════════════════════════════════════════════
-- ÉTAPE 4 — Compléter plante_source pour ail (id=18)
-- Déjà en base : ESCOP=5, PubMed=6, WHO=7, Allicin=9
-- Manquent    : CIQUAL=1, Vidal=13, Cavallito=14,
--               Behrouz=15, USDA=16, PMC=17
-- ════════════════════════════════════════════════════════════

INSERT IGNORE INTO plante_source (plante_id, source_id)
SELECT p.id, s.id
FROM plantes p, sources s
WHERE p.slug = 'ail-cultive'
AND s.id IN (1, 13, 14, 15, 16, 17);

