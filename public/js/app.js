// ================================================
// La Pharmacie — app.js
// ================================================
// 1. Smooth scroll sur les ancres internes
// 2. Filtre par catégorie (pills du hero)
// 3. Recherche live sur les cartes de plantes
// ================================================

document.addEventListener('DOMContentLoaded', () => {

    // ------------------------------------------------
    // 1. SMOOTH SCROLL
    // Toutes les ancres #section scrollent en douceur
    // ------------------------------------------------
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', e => {
            const id = link.getAttribute('href').slice(1);
            const target = document.getElementById(id);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ------------------------------------------------
    // 2. FILTRE PAR CATÉGORIE
    // Clic sur une pill → affiche uniquement les cartes
    // de cette catégorie. Second clic → réinitialise.
    // Les cartes ont data-cats="Aromatiques,Fleurs" etc.
    // ------------------------------------------------
    const pills   = document.querySelectorAll('.category-pill');
    const cards   = document.querySelectorAll('.public-card[data-cats]');
    const counter = document.querySelector('.section-title .count-label');

    pills.forEach(pill => {
        pill.addEventListener('click', e => {
            e.preventDefault();

            const isActive = pill.classList.contains('active');

            // Désactiver toutes les pills
            pills.forEach(p => p.classList.remove('active'));

            if (isActive) {
                // Deuxième clic → tout réafficher
                cards.forEach(c => c.classList.remove('hidden'));
                updateCounter(cards.length);
                return;
            }

            // Activer la pill cliquée
            pill.classList.add('active');
            const cat = pill.dataset.cat;

            let visible = 0;
            cards.forEach(card => {
                const cats = card.dataset.cats ? card.dataset.cats.split(',') : [];
                if (cats.includes(cat)) {
                    card.classList.remove('hidden');
                    visible++;
                } else {
                    card.classList.add('hidden');
                }
            });

            updateCounter(visible);

            // Scroll vers la section plantes
            const section = document.getElementById('plantes');
            if (section) section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    function updateCounter(n) {
        const span = document.querySelector('#plantes .section-title span');
        if (span) span.textContent = n;
    }

    // ------------------------------------------------
    // 3. RECHERCHE LIVE
    // Filtre en temps réel sur nom + nom latin
    // Cherche dans data-nom et data-latin des cartes
    // ------------------------------------------------
    const searchInput = document.getElementById('search-plantes');
    if (!searchInput) return;

    searchInput.addEventListener('input', () => {
        const q = searchInput.value.toLowerCase().trim();

        // Réinitialise le filtre catégorie si recherche active
        if (q.length > 0) {
            pills.forEach(p => p.classList.remove('active'));
        }

        let visible = 0;
        cards.forEach(card => {
            const nom   = (card.dataset.nom   || '').toLowerCase();
            const latin = (card.dataset.latin || '').toLowerCase();
            const match = !q || nom.includes(q) || latin.includes(q);
            card.classList.toggle('hidden', !match);
            if (match) visible++;
        });

        updateCounter(visible);

        // Message si aucun résultat
        const empty = document.getElementById('search-empty');
        if (empty) empty.style.display = visible === 0 ? 'block' : 'none';
    });

    // Effacer la recherche avec Échap
    searchInput.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
        }
    });

});
