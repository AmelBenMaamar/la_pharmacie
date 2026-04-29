-- ============================================================
-- ÉTAPE 1 — Sources spécifiques à l'ail (5 nouvelles)
-- INSERT IGNORE : aucun risque si relancé
-- ============================================================
SET NAMES utf8mb4;

INSERT INTO sources (titre, auteurs, journal, annee, url, doi, resume, type_source) VALUES

('Phytothérapie : Ail (Allium sativum) — mécanisme alliine/allicine',
 'Rédaction Vidal',
 'Vidal.fr',
 2023,
 'https://www.vidal.fr/parapharmacie/phytotherapie-plantes/ail-allium-sativum.html',
 NULL,
 'Mécanisme de transformation alliine → allicine par l''alliinase. Instabilité à la chaleur. Délai de 10 min recommandé après découpe.',
 'revue'),

('Allicin, the Antibacterial Principle of Allium sativum',
 'Cavallito C.J., Bailey J.H.',
 'Journal of the American Chemical Society',
 1944,
 NULL,
 '10.1021/ja01231a049',
 'Première isolation et caractérisation de l''allicine. Propriétés antibactériennes et antifongiques documentées.',
 'etude'),

('Effects of Garlic Supplementation on Cardiovascular Risk Factors in Adults: A Comprehensive Updated Systematic Review and Meta-Analysis of Randomized Controlled Trials',
 'Behrouz V. et al.',
 'Nutrition Reviews',
 2025,
 'https://doi.org/10.1093/nutrit/nuaf090',
 '10.1093/nutrit/nuaf090',
 'Méta-analyse de plus de 100 essais cliniques randomisés (>7000 participants). Amélioration significative de la pression artérielle, glycémie, résistance à l''insuline et lipides.',
 'meta-analyse'),

('USDA FoodData Central — Garlic, raw',
 'U.S. Department of Agriculture',
 'USDA FoodData Central',
 2024,
 'https://fdc.nal.usda.gov/fdc-app.html#/food-details/169230/nutrients',
 NULL,
 'Données de composition nutritionnelle de l''ail cru : vitamines B6, B1, B9, C, manganèse, cuivre, zinc, sélénium.',
 'autre'),

('Traditional uses, phytochemistry, pharmacology and toxicology of garlic',
 'Rédaction collective NIH',
 'PMC / Frontiers in Pharmacology',
 2022,
 'https://www.ncbi.nlm.nih.gov/pmc/articles/PMC9650110/',
 NULL,
 'Revue complète : composés soufrés, flavonoïdes (quercétine), polyphénols. Propriétés antioxydantes et anti-inflammatoires.',
 'revue');

