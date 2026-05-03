-- ============================================================
-- SEED BROCOLI — Brassica oleracea var. italica
-- Suit le protocole PROTOCOLE_PLANTE.md étapes 3 à 12
-- ============================================================
SET NAMES utf8mb4;

-- ════════════════════════════════════════════════════════════
-- ETAPE 3 — Composants manquants
-- En base : vitamine-c ✅ sulforaphane ✅ beta-carotene ✅
--           vitamine-k ✅ vitamine-b9 ✅ potassium ✅
-- A créer : glucoraphanine, calcium, indole-3-carbinol, luteine
-- ════════════════════════════════════════════════════════════

INSERT IGNORE INTO composants (nom, slug, famille, description) VALUES

('Glucoraphanine', 'glucoraphanine', 'phytochimique',
 'Glucosinolate precurseur du sulforaphane. Hydrolysee par la myrosinase lors de la mastication ou de la decoupe. La cuisson prolongee detruit la myrosinase et reduit la biodisponibilite du sulforaphane.'),

('Calcium', 'calcium', 'mineral',
 'Mineral essentiel a la mineralisation osseuse et dentaire, a la contraction musculaire et a la conduction nerveuse. AJR : 1000 mg (EFSA 2015).'),

('Indole-3-carbinol', 'indole-3-carbinol', 'phytochimique',
 'Indole derive des glucosinolates des Brassicacees. Module le metabolisme des oestrogenes. Proprietes antiproliferatives documentees in vitro et dans des modeles animaux.'),

('Luteine', 'luteine', 'phytochimique',
 'Carotenoidde present dans la retine et le cristallin. Protege contre la degenerescence maculaire liee a l''age (DMLA) et la cataracte. Pas d''AJR etabli.');

-- ════════════════════════════════════════════════════════════
-- ETAPE 4 — Vertus manquantes
-- A creer : sante-osseuse, sante-oculaire
-- ════════════════════════════════════════════════════════════

INSERT IGNORE INTO vertus (nom, slug, categorie, description) VALUES

('Sante osseuse', 'sante-osseuse', 'ossature',
 'Contribution a la mineralisation et au maintien de la densite osseuse. Implique la vitamine K (activation de l''osteocalcine), le calcium et le manganese.'),

('Sante oculaire', 'sante-oculaire', 'vision',
 'Protection de la retine et du cristallin contre le stress oxydatif. Reduction du risque de DMLA et de cataracte via les carotenoides (luteine, zeaxanthine).');

-- ════════════════════════════════════════════════════════════
-- ETAPE 5 — Liens composant_vertu (permanents, universels)
-- INSERT IGNORE : skip si lien deja present
-- ════════════════════════════════════════════════════════════

INSERT IGNORE INTO composant_vertu (composant_id, vertu_id, niveau_evidence, notes)

-- glucoraphanine
SELECT c.id, v.id, 'fort', 'Precurseur direct du sulforaphane. Activation voie Nrf2. Fahey et al. 1997.'
FROM composants c, vertus v WHERE c.slug='glucoraphanine' AND v.slug='anticancereux-preventif'
UNION ALL
SELECT c.id, v.id, 'fort', 'Hydrolyse par myrosinase en sulforaphane, inducteur des enzymes de detoxification hepatique phase II.'
FROM composants c, vertus v WHERE c.slug='glucoraphanine' AND v.slug='hepatoprotecteur'
UNION ALL
SELECT c.id, v.id, 'modere', 'Reduction du stress oxydatif via activation Nrf2 par le sulforaphane derive.'
FROM composants c, vertus v WHERE c.slug='glucoraphanine' AND v.slug='antioxydant'

-- calcium
UNION ALL
SELECT c.id, v.id, 'fort', 'Composant principal de l hydroxyapatite osseuse. EFSA 2017.'
FROM composants c, vertus v WHERE c.slug='calcium' AND v.slug='sante-osseuse'
UNION ALL
SELECT c.id, v.id, 'fort', 'Indispensable a la contraction musculaire et a la transmission neuromusculaire.'
FROM composants c, vertus v WHERE c.slug='calcium' AND v.slug='systeme-musculaire'
UNION ALL
SELECT c.id, v.id, 'modere', 'Role dans la conduction nerveuse et la liberation des neurotransmetteurs.'
FROM composants c, vertus v WHERE c.slug='calcium' AND v.slug='systeme-nerveux'
UNION ALL
SELECT c.id, v.id, 'modere', 'Apport en calcium contribue a la remineralisation generale.'
FROM composants c, vertus v WHERE c.slug='calcium' AND v.slug='remineralisant'

-- indole-3-carbinol
UNION ALL
SELECT c.id, v.id, 'modere', 'Module le metabolisme des oestrogenes. Proprietes antiproliferatives in vitro et animaux. Higdon et al. 2007.'
FROM composants c, vertus v WHERE c.slug='indole-3-carbinol' AND v.slug='anticancereux-preventif'
UNION ALL
SELECT c.id, v.id, 'modere', 'Modulation des voies de signalisation inflammatoires NF-kB.'
FROM composants c, vertus v WHERE c.slug='indole-3-carbinol' AND v.slug='anti-inflammatoire'
UNION ALL
SELECT c.id, v.id, 'modere', 'Induction des enzymes de detoxification hepatique de phase II.'
FROM composants c, vertus v WHERE c.slug='indole-3-carbinol' AND v.slug='hepatoprotecteur'

-- luteine
UNION ALL
SELECT c.id, v.id, 'fort', 'Filtre les longueurs d onde bleues. Protege la macula et le cristallin. Krinsky & Johnson 2005.'
FROM composants c, vertus v WHERE c.slug='luteine' AND v.slug='sante-oculaire'
UNION ALL
SELECT c.id, v.id, 'fort', 'Carotenoidde antioxydant majeur. Neutralise les radicaux libres dans les tissus oculaires.'
FROM composants c, vertus v WHERE c.slug='luteine' AND v.slug='antioxydant'
UNION ALL
SELECT c.id, v.id, 'modere', 'Reduction de l inflammation chronique par modulation des cytokines.'
FROM composants c, vertus v WHERE c.slug='luteine' AND v.slug='anti-inflammatoire'

-- vitamine-k (liens nouveaux specifiques au brocoli)
UNION ALL
SELECT c.id, v.id, 'fort', 'Cofacteur de la carboxylation de l osteocalcine. Mineralisation osseuse. EFSA 2017.'
FROM composants c, vertus v WHERE c.slug='vitamine-k' AND v.slug='sante-osseuse'
UNION ALL
SELECT c.id, v.id, 'fort', 'Cofacteur des facteurs de coagulation II, VII, IX, X. EFSA 2017.'
FROM composants c, vertus v WHERE c.slug='vitamine-k' AND v.slug='cicatrisant';

-- ════════════════════════════════════════════════════════════
-- ETAPE 6 — Liens plante_composant (concentrations brocoli cru)
-- Sources : CIQUAL 2020 / USDA FoodData Central #170379
-- vitamine-c, sulforaphane, beta-carotene deja lies — INSERT IGNORE
-- ════════════════════════════════════════════════════════════

INSERT IGNORE INTO plante_composant (plante_id, composant_id, concentration, notes)
SELECT p.id, c.id, '89,2 mg/100g', 'CIQUAL 2020 — AJR 111%'
FROM plantes p JOIN composants c ON c.slug='vitamine-c' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, c.id, '0,1-0,5%', 'CIQUAL 2020 — Active par myrosinase lors decoupe. Cuisson vapeur douce recommandee'
FROM plantes p JOIN composants c ON c.slug='sulforaphane' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, c.id, '0,4 mg/100g', 'CIQUAL 2020 — Biodisponibilite amelioree par cuisson legere'
FROM plantes p JOIN composants c ON c.slug='beta-carotene' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, c.id, '102 µg/100g', 'CIQUAL 2020 — AJR 136%'
FROM plantes p JOIN composants c ON c.slug='vitamine-k' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, c.id, '63 µg/100g', 'CIQUAL 2020 — AJR 32%'
FROM plantes p JOIN composants c ON c.slug='vitamine-b9' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, c.id, '316 mg/100g', 'CIQUAL 2020 — AJR 16%'
FROM plantes p JOIN composants c ON c.slug='potassium' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, c.id, '47 mg/100g', 'CIQUAL 2020 — AJR 6%'
FROM plantes p JOIN composants c ON c.slug='calcium' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, c.id, '~65 mg/100g', 'USDA FoodData Central #170379 — precurseur sulforaphane'
FROM plantes p JOIN composants c ON c.slug='glucoraphanine' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, c.id, '~100 mg/100g', 'Higdon et al. 2007 — teneur estimee cruciferes'
FROM plantes p JOIN composants c ON c.slug='indole-3-carbinol' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, c.id, '0,6 mg/100g', 'USDA FoodData Central #170379'
FROM plantes p JOIN composants c ON c.slug='luteine' WHERE p.slug='brocoli';

-- ════════════════════════════════════════════════════════════
-- ETAPE 7 — Liens plante_vertu
-- TOUTES les vertus de composant_vertu doivent etre presentes
-- ════════════════════════════════════════════════════════════

INSERT IGNORE INTO plante_vertu (plante_id, vertu_id, source)
SELECT p.id, v.id, 'Fahey JW et al. 1997 — PNAS / INCa 2015'
FROM plantes p JOIN vertus v ON v.slug='anticancereux-preventif' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, v.id, 'CIQUAL 2020 — vitamine C, sulforaphane, luteine, beta-carotene'
FROM plantes p JOIN vertus v ON v.slug='antioxydant' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, v.id, 'Higdon et al. 2007 — indole-3-carbinol, luteine'
FROM plantes p JOIN vertus v ON v.slug='anti-inflammatoire' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, v.id, 'Fahey et al. 2012 — sulforaphane, glucoraphanine, indole-3-carbinol'
FROM plantes p JOIN vertus v ON v.slug='hepatoprotecteur' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, v.id, 'EFSA 2017 — vitamine K / CIQUAL 2020 — calcium'
FROM plantes p JOIN vertus v ON v.slug='sante-osseuse' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, v.id, 'Krinsky & Johnson 2005 — luteine / USDA — beta-carotene'
FROM plantes p JOIN vertus v ON v.slug='sante-oculaire' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, v.id, 'CIQUAL 2020 — vitamine C, calcium'
FROM plantes p JOIN vertus v ON v.slug='cicatrisant' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, v.id, 'CIQUAL 2020 — vitamine C, beta-carotene'
FROM plantes p JOIN vertus v ON v.slug='immunostimulant' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, v.id, 'CIQUAL 2020 — calcium, potassium, vitamine B9'
FROM plantes p JOIN vertus v ON v.slug='remineralisant' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, v.id, 'CIQUAL 2020 — calcium, potassium'
FROM plantes p JOIN vertus v ON v.slug='systeme-musculaire' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, v.id, 'CIQUAL 2020 — calcium, potassium, vitamine B9'
FROM plantes p JOIN vertus v ON v.slug='systeme-nerveux' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, v.id, 'CIQUAL 2020 — potassium, vitamine C'
FROM plantes p JOIN vertus v ON v.slug='l-equilibre-hydrique' WHERE p.slug='brocoli'
UNION ALL
SELECT p.id, v.id, 'PubMed / Higdon 2007 — sulforaphane hypoglycemiant'
FROM plantes p JOIN vertus v ON v.slug='hypoglycemiant' WHERE p.slug='brocoli';

-- ════════════════════════════════════════════════════════════
-- ETAPE 8 — Sources manquantes (5 nouvelles)
-- Verifier doublons apres insertion
-- ════════════════════════════════════════════════════════════

INSERT INTO sources (titre, auteurs, journal, annee, url, doi, resume, type_source) VALUES

('Alimentation, nutrition, activite physique et cancers : la synthese des recommandations',
 'Institut National du Cancer (INCa)',
 'INCa / WCRF / AIRC',
 2015,
 'https://www.e-cancer.fr/Expertises-et-publications/Catalogue-des-publications/Alimentation-nutrition-activite-physique-et-cancers-la-synthese',
 NULL,
 'Recommandations francaises officielles sur les cruciferes et la prevention du cancer. Cite le sulforaphane et les glucosinolates. Reference INCa de reference en France.',
 'rapport'),

('Actualisation des reperes du PNNS : revision des reperes de consommations alimentaires pour les adultes',
 'ANSES — Agence nationale de securite sanitaire',
 'Avis ANSES — Rapport d expertise collective',
 2021,
 'https://www.anses.fr/fr/content/les-recommandations-alimentaires',
 NULL,
 'Reperes de consommation des legumes cruciferes et role dans la prevention des maladies chroniques. Reference nationale francaise.',
 'rapport'),

('Dietary reference values for vitamin K',
 'EFSA Panel on Dietetic Products, Nutrition and Allergies (NDA)',
 'EFSA Journal',
 2017,
 'https://doi.org/10.2903/j.efsa.2017.4780',
 '10.2903/j.efsa.2017.4780',
 'Valeurs nutritionnelles de reference pour la vitamine K. AJR adulte : 70 µg/j. Role dans la coagulation et la mineralisation osseuse. Autorite de reference utilisee en France.',
 'rapport'),

('Brassicaceae et glucosinolates : biodisponibilite et effets sante',
 'Lyan B, Cochet B, Georgé S, Renard CMGC',
 'Innovations Agronomiques — INRAE',
 2008,
 'https://www.inrae.fr',
 NULL,
 'Revue francaise sur les glucosinolates des Brassicacees. Mecanismes d hydrolyse par la myrosinase. Effets du mode de cuisson sur la biodisponibilite du sulforaphane.',
 'revue'),

('Brocoli (Brassica oleracea var. italica) — proprietes nutritionnelles et effets sur la sante',
 'Redaction Vidal',
 'Vidal.fr — Encyclopedie medicale',
 2023,
 'https://www.vidal.fr',
 NULL,
 'Synthese medicale en francais : sulforaphane, indoles, vitamine K, effets anticancereux et cardiovasculaires du brocoli.',
 'revue');

-- Verification doublons
SELECT id, titre, annee FROM sources ORDER BY id;

-- ════════════════════════════════════════════════════════════
-- ETAPE 9 — Liens plante_source
-- Deja en base : CIQUAL=1, PubMed=6, Broccoli sprouts=8, USDA=16
-- Nouveaux IDs a confirmer apres etape 8
-- ════════════════════════════════════════════════════════════

INSERT IGNORE INTO plante_source (plante_id, source_id)
SELECT p.id, s.id FROM plantes p, sources s
WHERE p.slug = 'brocoli'
AND s.id IN (1, 6, 8, 16);

-- ════════════════════════════════════════════════════════════
-- ETAPE 10 — Liens composant_source
-- ════════════════════════════════════════════════════════════

INSERT IGNORE INTO composant_source (composant_id, source_id, notes)
-- sulforaphane
SELECT c.id, 8, 'Fahey 1997 — source fondatrice sulforaphane/glucoraphanine'
FROM composants c WHERE c.slug='sulforaphane'
UNION ALL
SELECT c.id, 1, 'CIQUAL 2020 — teneur sulforaphane brocoli cru'
FROM composants c WHERE c.slug='sulforaphane'
-- glucoraphanine
UNION ALL
SELECT c.id, 8, 'Fahey 1997 — glucoraphanine precurseur sulforaphane'
FROM composants c WHERE c.slug='glucoraphanine'
UNION ALL
SELECT c.id, 16, 'USDA FoodData Central #170379 — glucoraphanine brocoli'
FROM composants c WHERE c.slug='glucoraphanine'
-- vitamine-k
UNION ALL
SELECT c.id, 1, 'CIQUAL 2020 — vitamine K brocoli : 102 µg/100g AJR 136%'
FROM composants c WHERE c.slug='vitamine-k'
UNION ALL
SELECT c.id, 16, 'USDA FoodData Central #170379 — vitamine K'
FROM composants c WHERE c.slug='vitamine-k'
-- vitamine-b9
UNION ALL
SELECT c.id, 1, 'CIQUAL 2020 — folate brocoli : 63 µg/100g AJR 32%'
FROM composants c WHERE c.slug='vitamine-b9'
-- calcium
UNION ALL
SELECT c.id, 1, 'CIQUAL 2020 — calcium brocoli : 47 mg/100g AJR 6%'
FROM composants c WHERE c.slug='calcium'
UNION ALL
SELECT c.id, 16, 'USDA FoodData Central #170379 — calcium'
FROM composants c WHERE c.slug='calcium'
-- beta-carotene
UNION ALL
SELECT c.id, 1, 'CIQUAL 2020 — beta-carotene brocoli : 0,4 mg/100g'
FROM composants c WHERE c.slug='beta-carotene'
UNION ALL
SELECT c.id, 16, 'USDA FoodData Central #170379 — beta-carotene'
FROM composants c WHERE c.slug='beta-carotene'
-- indole-3-carbinol
UNION ALL
SELECT c.id, 6, 'PubMed — indole-3-carbinol proprietes anticancereuses'
FROM composants c WHERE c.slug='indole-3-carbinol'
-- luteine
UNION ALL
SELECT c.id, 1, 'CIQUAL 2020 — luteine brocoli : 0,6 mg/100g'
FROM composants c WHERE c.slug='luteine'
UNION ALL
SELECT c.id, 16, 'USDA FoodData Central #170379 — luteine'
FROM composants c WHERE c.slug='luteine';

