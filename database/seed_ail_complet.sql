-- ============================================================
-- SEED AIL — Complément uniquement (sans écraser l'existant)
-- ail-cultive + allicine + 5 vertus allicine déjà en base ✅
-- ============================================================

SET NAMES utf8mb4;

-- ── 1. COMPOSANTS MANQUANTS ─────────────────────────────────
-- (INSERT IGNORE = skip si slug déjà présent)

INSERT IGNORE INTO composants (nom, slug, famille, description) VALUES
('Vitamine B6 (pyridoxine)', 'vitamine-b6', 'vitamine',
 'Coenzyme impliquee dans le metabolisme des acides amines, la synthese des neurotransmetteurs et la regulation hormonale. AJR : 1,4 mg (EFSA 2019).'),

('Vitamine B1 (thiamine)', 'vitamine-b1', 'vitamine',
 'Intervient dans le metabolisme des glucides et le fonctionnement du systeme nerveux. AJR : 1,1 mg (EFSA 2019).'),

('Vitamine B9 (folate)', 'vitamine-b9', 'vitamine',
 'Indispensable a la synthese de l''ADN et a la division cellulaire. AJR : 200 µg (EFSA 2019).'),

('Manganese', 'manganese', 'mineral',
 'Cofacteur enzymatique implique dans le metabolisme osseux et la defense antioxydante (MnSOD). AJR : 2,3 mg (EFSA 2013).'),

('Cuivre', 'cuivre', 'mineral',
 'Cofacteur d''enzymes antioxydantes (Cu/Zn SOD), intervient dans la formation du tissu conjonctif. AJR : 1,0 mg (EFSA 2015).'),

('Zinc', 'zinc', 'mineral',
 'Cofacteur de plus de 300 enzymes. Role cle dans l''immunite, la cicatrisation et la synthese proteique. AJR : 10 mg (EFSA 2014).'),

('Selenium', 'selenium', 'mineral',
 'Oligoelement rare dans l''alimentation. Composant des selenoproteines (glutathion peroxydase). AJR : 55 µg (EFSA 2014).');

-- ── 2. LIENS composant_vertu POUR LES NOUVEAUX COMPOSANTS ───
-- On utilise uniquement les vertus déjà existantes en base

INSERT IGNORE INTO composant_vertu (composant_id, vertu_id, niveau_evidence, notes)

-- vitamine-b6
SELECT c.id, v.id, 'fort', 'Coenzyme des aminotransferases. Influence la proliferation des lymphocytes T.'
FROM composants c, vertus v
WHERE c.slug = 'vitamine-b6' AND v.slug = 'immunostimulant'

UNION ALL
SELECT c.id, v.id, 'modere', 'Impliquee dans le metabolisme de l''homocysteine.'
FROM composants c, vertus v
WHERE c.slug = 'vitamine-b6' AND v.slug = 'cardioprotecteur'

UNION ALL
SELECT c.id, v.id, 'modere', 'Role dans la synthese des neurotransmetteurs.'
FROM composants c, vertus v
WHERE c.slug = 'vitamine-b6' AND v.slug = 'systeme-nerveux'

-- vitamine-b1
UNION ALL
SELECT c.id, v.id, 'fort', 'Indispensable au metabolisme energetique des neurones.'
FROM composants c, vertus v
WHERE c.slug = 'vitamine-b1' AND v.slug = 'systeme-nerveux'

UNION ALL
SELECT c.id, v.id, 'modere', 'Soutien de la contraction musculaire via la production d''ATP.'
FROM composants c, vertus v
WHERE c.slug = 'vitamine-b1' AND v.slug = 'systeme-musculaire'

-- vitamine-b9
UNION ALL
SELECT c.id, v.id, 'modere', 'Soutien de la proliferation des cellules immunitaires.'
FROM composants c, vertus v
WHERE c.slug = 'vitamine-b9' AND v.slug = 'immunostimulant'

UNION ALL
SELECT c.id, v.id, 'modere', 'Reduction de l''homocysteine, facteur de risque cardiovasculaire.'
FROM composants c, vertus v
WHERE c.slug = 'vitamine-b9' AND v.slug = 'cardioprotecteur'

-- manganese
UNION ALL
SELECT c.id, v.id, 'fort', 'Composant de la MnSOD, principale enzyme antioxydante mitochondriale.'
FROM composants c, vertus v
WHERE c.slug = 'manganese' AND v.slug = 'antioxydant'

UNION ALL
SELECT c.id, v.id, 'fort', 'Cofacteur des enzymes de la matrice osseuse (glycosyltransferases).'
FROM composants c, vertus v
WHERE c.slug = 'manganese' AND v.slug = 'remineralisant'

-- cuivre
UNION ALL
SELECT c.id, v.id, 'modere', 'Cofacteur de la Cu/Zn superoxyde dismutase.'
FROM composants c, vertus v
WHERE c.slug = 'cuivre' AND v.slug = 'antioxydant'

UNION ALL
SELECT c.id, v.id, 'modere', 'Necessaire a la lysyl oxydase, enzyme de reticulation du collagene.'
FROM composants c, vertus v
WHERE c.slug = 'cuivre' AND v.slug = 'cicatrisant'

-- zinc
UNION ALL
SELECT c.id, v.id, 'fort', 'Indispensable a la maturation des lymphocytes T et au signal des cytokines.'
FROM composants c, vertus v
WHERE c.slug = 'zinc' AND v.slug = 'immunostimulant'

UNION ALL
SELECT c.id, v.id, 'modere', 'Composant de la Cu/Zn superoxyde dismutase.'
FROM composants c, vertus v
WHERE c.slug = 'zinc' AND v.slug = 'antioxydant'

UNION ALL
SELECT c.id, v.id, 'fort', 'Cofacteur indispensable a la cicatrisation tissulaire.'
FROM composants c, vertus v
WHERE c.slug = 'zinc' AND v.slug = 'cicatrisant'

-- selenium
UNION ALL
SELECT c.id, v.id, 'fort', 'Composant de la glutathion peroxydase, principale enzyme antioxydante.'
FROM composants c, vertus v
WHERE c.slug = 'selenium' AND v.slug = 'antioxydant'

UNION ALL
SELECT c.id, v.id, 'fort', 'Regule la reponse immunitaire adaptative via les selenoproteines.'
FROM composants c, vertus v
WHERE c.slug = 'selenium' AND v.slug = 'immunostimulant';

-- ── 3. LIER LES COMPOSANTS A L'AIL ──────────────────────────
-- allicine déjà lié ✅ — on ajoute les 10 autres

INSERT IGNORE INTO plante_composant (plante_id, composant_id, concentration, notes)
SELECT p.id, c.id, concentration, notes
FROM plantes p,
(SELECT slug, concentration, notes FROM (VALUES
    ROW('vitamine-b6',   '1,235 mg/100g', 'CIQUAL 2020 / USDA — AJR 88%'),
    ROW('vitamine-b1',   '0,200 mg/100g', 'CIQUAL 2020 — AJR 18%'),
    ROW('vitamine-b9',   '3,0 µg/100g',   'CIQUAL 2020 — teneur modeste'),
    ROW('vitamine-c',    '31,2 mg/100g',  'CIQUAL 2020 — AJR 39%, variable selon fraicheur'),
    ROW('manganese',     '1,672 mg/100g', 'USDA FoodData Central — AJR 73%'),
    ROW('cuivre',        '0,299 mg/100g', 'USDA FoodData Central — AJR 30%'),
    ROW('potassium',     '401 mg/100g',   'CIQUAL 2020 — AJR 20%'),
    ROW('zinc',          '1,160 mg/100g', 'USDA FoodData Central — AJR 12%'),
    ROW('selenium',      '14,2 µg/100g',  'USDA FoodData Central — AJR 26%'),
    ROW('quercetine',    '~47 mg/100g',   'PMC9650110 — flavonoides totaux'),
    ROW('les-polyphenols','~72 mg/100g',  'Nutripure.fr / PMC9650110 — polyphenols totaux estimes')
) AS t(slug, concentration, notes)) AS data
JOIN composants c ON c.slug = data.slug
WHERE p.slug = 'ail-cultive';

-- ── 4. VERTUS GLOBALES DE L'AIL (plante_vertu) ──────────────

INSERT IGNORE INTO plante_vertu (plante_id, vertu_id, source)
SELECT p.id, v.id, source
FROM plantes p,
(SELECT slug, source FROM (VALUES
    ROW('antibacterien',       'OMS Monographs Vol.1 1999 / Cavallito & Bailey 1944'),
    ROW('antifongique',        'OMS Monographs Vol.1 1999'),
    ROW('cardioprotecteur',    'Behrouz et al. 2025 — Nutrition Reviews doi:10.1093/nutrit/nuaf090'),
    ROW('hypoglycemiant',      'Behrouz et al. 2025 — amelioration glycemie et insulino-resistance'),
    ROW('anticancereux-preventif', 'PMC9650110 — proprietes antiproliferatives in vitro'),
    ROW('antioxydant',         'PMC9650110 / Nutripure.fr — quercetine et polyphenols'),
    ROW('anti-inflammatoire',  'Behrouz et al. 2025 — reduction marqueurs inflammatoires'),
    ROW('immunostimulant',     'OMS — usage traditionnel reconnu infections respiratoires')
) AS t(slug, source)) AS data
JOIN vertus v ON v.slug = data.slug
WHERE p.slug = 'ail-cultive';

