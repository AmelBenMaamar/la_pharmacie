<?php
function renderMarkdown(string $text): string {
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    $text = preg_replace('/^### (.+)$/m', '<h4>$1</h4>', $text);
    $text = preg_replace('/^## (.+)$/m',  '<h3>$1</h3>', $text);
    $text = preg_replace('/^# (.+)$/m',   '<h2>$1</h2>', $text);
    $text = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text);
    $text = preg_replace('/\*(.+?)\*/s',     '<em>$1</em>', $text);
    $text = preg_replace('/^\* (.+)$/m',  '<li>$1</li>', $text);
    $text = preg_replace('/^> (.+)$/m',   '<blockquote>$1</blockquote>', $text);
    $text = preg_replace('/^---$/m', '<hr>', $text);
    $text = preg_replace('/\n{2,}/', '</p><p>', $text);
    $text = '<p>' . $text . '</p>';
    $text = preg_replace('/<p>(<h[2-4]>.*?<\/h[2-4]>)<\/p>/s', '$1', $text);
    $text = preg_replace('/<p>(<hr>)<\/p>/s', '$1', $text);
    return $text;
}
?>
<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<div class="fiche-header">
    <div class="fiche-header-inner">
        <?php if (!empty($plante['image'])): ?>
            <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($plante['image']) ?>"
                 alt="<?= htmlspecialchars($plante['nom']) ?>"
                 class="fiche-img">
        <?php else: ?>
            <div class="fiche-img-placeholder">
                <?= icon('plante', 64, 'placeholder-icon') ?>
            </div>
        <?php endif; ?>
        <div>
            <?php if (!empty($categories)): ?>
                <div style="display:flex; flex-wrap:wrap; gap:0.4rem; margin-bottom:0.75rem;">
                    <?php foreach ($categories as $cat): ?>
                        <span class="tag tag-plante"><?= htmlspecialchars($cat['nom']) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <h1 class="fiche-title"><?= htmlspecialchars($plante['nom']) ?></h1>
            <?php if (!empty($plante['nom_latin'])): ?>
                <p class="fiche-latin"><?= htmlspecialchars($plante['nom_latin']) ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="fiche-body">

    <?php if (!empty($plante['description'])): ?>
    <div class="fiche-section">
        <div class="fiche-description">
            <?= renderMarkdown($plante['description']) ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($composants) || !empty($vertus)): ?>
    <div class="fiche-section graphe-section">
        <h3><?= icon('composant', 18, 'section-icon composant') ?> Carte des liens</h3>
        <div class="graphe-legende">
            <span class="legende-item legende-plante">Plante</span>
            <span class="legende-item legende-composant">Composants</span>
            <span class="legende-item legende-vertu">Vertus</span>
        </div>
        <div class="graphe-wrap">
            <canvas id="graphe-canvas"></canvas>
            <div id="graphe-tooltip" class="graphe-tooltip"></div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($composants)): ?>
    <div class="fiche-section">
        <h3><?= icon('composant', 18, 'section-icon composant') ?> Composants actifs
            <span style="font-size:0.8rem;color:var(--texte-light);font-family:var(--font-sans);font-weight:400;"><?= count($composants) ?></span>
        </h3>
        <div class="tags-cloud">
            <?php foreach ($composants as $c): ?>
                <a href="<?= APP_URL ?>/composants/<?= htmlspecialchars($c['slug']) ?>"
                   class="tag tag-composant tag-lg">
                    <?= htmlspecialchars($c['nom']) ?>
                    <?php if (!empty($c['famille'])): ?>
                        <small><?= htmlspecialchars($c['famille']) ?></small>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($vertus)): ?>
    <div class="fiche-section">
        <h3><?= icon('vertu', 18, 'section-icon vertu') ?> Vertus thérapeutiques
            <span style="font-size:0.8rem;color:var(--texte-light);font-family:var(--font-sans);font-weight:400;"><?= count($vertus) ?></span>
        </h3>
        <div class="tags-cloud">
            <?php foreach ($vertus as $v): ?>
                <a href="<?= APP_URL ?>/vertus/<?= htmlspecialchars($v['slug']) ?>"
                   class="tag tag-vertu tag-lg">
                    <?= htmlspecialchars($v['nom']) ?>
                    <?php if (!empty($v['source'])): ?>
                        <small><?= htmlspecialchars($v['source']) ?></small>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (empty($composants) && empty($vertus)): ?>
    <div class="fiche-section" style="text-align:center; color:var(--texte-light); padding:3rem;">
        <?= icon('plante', 48, 'placeholder-icon') ?>
        <p style="margin-top:0.75rem;">Aucun lien renseigné pour cette plante pour l'instant.</p>
    </div>
    <?php endif; ?>

    <p style="margin-top:1rem;">
        <a href="<?= APP_URL ?>/" class="btn btn-secondary btn-sm">← Retour à l'accueil</a>
    </p>

</div>

<script>
(function () {
    /* ── Données PHP injectées ───────────────────────────────────────── */
    const APP_URL    = '<?= APP_URL ?>';
    const planteNom  = '<?= addslashes($plante['nom']) ?>';
    const composants = <?= json_encode(array_map(fn($c) => ['nom'=>$c['nom'],'slug'=>$c['slug']], $composants)) ?>;
    const vertus     = <?= json_encode(array_map(fn($v) => ['nom'=>$v['nom'],'slug'=>$v['slug']], $vertus)) ?>;
    /* liens_cv : [{composant_slug, vertu_slug}]
       Si vide, les vertus se rattachent à la plante (fallback) */
    const liensCv    = <?= json_encode($liens_cv ?? []) ?>;

    /* ── Palette ─────────────────────────────────────────────────────── */
    const FILL   = { plante:'#DCFCF2', composant:'#EDFDFF', vertu:'#F9FCDC' };
    const STROKE = { plante:'#a0ead8', composant:'#a0d4ea', vertu:'#d8e8a0' };
    const TEXT   = '#044B71';
    const LINE_C = '#a0d4ea';   /* plante → composant */
    const LINE_V = '#b8d48a';   /* composant → vertu  */
    const BG     = '#F5F0E8';
    const ANIM_DUR = 700;       /* ms */

    /* ── Setup canvas ────────────────────────────────────────────────── */
    const canvas  = document.getElementById('graphe-canvas');
    const tooltip = document.getElementById('graphe-tooltip');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const dpr = () => window.devicePixelRatio || 1;

    let nodes = [], edges = [], hovered = null, tapped = null;
    let W = 0, H = 0, animStart = null, progress = 0;

    /* ── Resize ──────────────────────────────────────────────────────── */
    function resize() {
        W = canvas.parentElement.offsetWidth;
        H = Math.max(560, Math.min(750, W * 0.72));
        canvas.width        = Math.round(W * dpr());
        canvas.height       = Math.round(H * dpr());
        canvas.style.width  = W + 'px';
        canvas.style.height = H + 'px';
        buildGraph();
        animStart = null;
        requestAnimationFrame(animate);
    }

    /* ── Construction nœuds + arêtes ────────────────────────────────── */
    function buildGraph() {
        nodes = []; edges = [];
        const cx = Math.round(W / 2), cy = Math.round(H / 2);

        const nC   = Math.max(composants.length, 1);
        const nV   = Math.max(vertus.length, 1);
        const base = Math.min(W, H) * 0.34;
        const r1   = base;
        const r2   = base * 1.72;

        const rPlante = 52;
        const rC = Math.max(34, Math.min(48, 200 / nC));
        const rV = Math.max(30, Math.min(44, 200 / nV));

        /* Plante centrale */
        const nPlante = {
            nom: planteNom, type: 'plante',
            x: cx, y: cy, r: rPlante, url: null,
            idx: 0, neighbors: new Set()
        };
        nodes.push(nPlante);

        /* Composants — anneau interne */
        const compNodes = [];
        composants.forEach((c, i) => {
            const a = 2 * Math.PI * i / nC - Math.PI / 2;
            const n = {
                ...c, type: 'composant',
                x: Math.round(cx + r1 * Math.cos(a)),
                y: Math.round(cy + r1 * Math.sin(a)),
                r: rC, url: APP_URL + '/composants/' + c.slug,
                idx: 1 + i, neighbors: new Set(), angle: a
            };
            nodes.push(n);
            compNodes.push(n);
            edges.push({ from: nPlante, to: n, type: 'composant' });
            nPlante.neighbors.add(n.idx);
            n.neighbors.add(nPlante.idx);
        });

        const compBySlug = {};
        compNodes.forEach(n => { compBySlug[n.slug] = n; });

        /* Vertus — anneau externe, UNE bulle par vertu unique
           Chaque vertu est reliée à TOUS ses composants parents via .filter() */
        vertus.forEach((v, i) => {
            const a = 2 * Math.PI * i / nV - Math.PI / 2 + (Math.PI / nV);
            const nv = {
                ...v, type: 'vertu',
                x: Math.round(cx + r2 * Math.cos(a)),
                y: Math.round(cy + r2 * Math.sin(a)),
                r: rV, url: APP_URL + '/vertus/' + v.slug,
                idx: 1 + composants.length + i,
                neighbors: new Set()
            };
            nodes.push(nv);

            /* Tous les composants parents de cette vertu */
            const parents = liensCv
                .filter(l => l.vertu_slug === v.slug && compBySlug[l.composant_slug])
                .map(l => compBySlug[l.composant_slug]);

            const sources = parents.length > 0 ? parents : [nPlante];
            sources.forEach(parent => {
                edges.push({ from: parent, to: nv, type: 'vertu' });
                parent.neighbors.add(nv.idx);
                nv.neighbors.add(parent.idx);
            });
        });

        /* Clamp : rien ne déborde du canvas */
        const margin = 16;
        nodes.forEach(n => {
            n.x = Math.max(n.r + margin, Math.min(W - n.r - margin, n.x));
            n.y = Math.max(n.r + margin, Math.min(H - n.r - margin, n.y));
        });
    }

    /* ── Dégradé radial (V1) ─────────────────────────────────────────── */
    function makeGradient(n, r) {
        const g = ctx.createRadialGradient(n.x, n.y, 0, n.x, n.y, r);
        g.addColorStop(0,   '#ffffff');
        g.addColorStop(0.6, FILL[n.type]);
        g.addColorStop(1,   STROKE[n.type]);
        return g;
    }

    /* ── Texte multiligne ────────────────────────────────────────────── */
    function wrapText(text, maxW) {
        const words = text.split(' ');
        const lines = []; let cur = '';
        words.forEach(w => {
            const t = cur ? cur+' '+w : w;
            if (ctx.measureText(t).width > maxW - 8) { if (cur) lines.push(cur); cur = w; }
            else cur = t;
        });
        if (cur) lines.push(cur);
        if (lines.length > 2) { lines[1] = lines[1].slice(0,-1)+'…'; return lines.slice(0,2); }
        return lines;
    }

    /* ── Draw ────────────────────────────────────────────────────────── */
    function draw(prog) {
        prog = (prog === undefined) ? 1 : prog;
        ctx.setTransform(dpr(), 0, 0, dpr(), 0, 0);
        ctx.clearRect(0, 0, W, H);

        /* Fond */
        ctx.fillStyle = BG;
        ctx.beginPath(); ctx.roundRect(0, 0, W, H, 14); ctx.fill();
        if (!nodes.length) return;

        const center = nodes[0];

        /* ── Arêtes animées (A1) + couleur par type ───────────────────── */
        edges.forEach(e => {
            const isComp = (e.type === 'composant');
            /* Timing décalé : composants 0→0.6, vertus 0.3→1 */
            const p0 = isComp ? 0   : 0.3;
            const p1 = isComp ? 0.6 : 1.0;
            const t  = Math.max(0, Math.min(1, (prog - p0) / (p1 - p0)));
            if (t <= 0) return;

            /* Point intermédiaire animé */
            const tx = e.from.x + (e.to.x - e.from.x) * t;
            const ty = e.from.y + (e.to.y - e.from.y) * t;

            /* I1 : atténue les arêtes hors focus */
            const dimEdge = hovered && hovered !== e.from && hovered !== e.to;
            ctx.globalAlpha = dimEdge ? 0.12 : 0.75;
            ctx.setLineDash(isComp ? [] : [5, 4]);
            ctx.strokeStyle = isComp ? LINE_C : LINE_V;
            ctx.lineWidth   = isComp ? 1.5 : 1;

            ctx.beginPath(); ctx.moveTo(e.from.x, e.from.y); ctx.lineTo(tx, ty); ctx.stroke();
            ctx.globalAlpha = 1;
        });
        ctx.setLineDash([]);

        /* ── Nœuds animés (A1) ────────────────────────────────────────── */
        nodes.forEach(n => {
            /* Timing par type */
            let p0, p1;
            if      (n.type === 'plante')    { p0=0;   p1=0.25; }
            else if (n.type === 'composant') { p0=0.1; p1=0.6;  }
            else                             { p0=0.4; p1=1.0;  }
            const t = Math.max(0, Math.min(1, (prog - p0) / (p1 - p0)));
            if (t <= 0) return;

            /* Position interpolée depuis le centre (A1) */
            const nx = Math.round(center.x + (n.x - center.x) * t);
            const ny = Math.round(center.y + (n.y - center.y) * t);
            const r  = n.r * t;

            /* I1 : opacité selon voisinage */
            const isNeighbor = hovered && (hovered === n || hovered.neighbors.has(n.idx));
            const dimmed     = hovered && !isNeighbor;
            ctx.globalAlpha  = dimmed ? 0.15 : 1;

            const hov    = (hovered === n);
            const radius = hov ? r + 4 : r;

            /* Shadow hover */
            ctx.shadowColor = hov ? STROKE[n.type] : 'transparent';
            ctx.shadowBlur  = hov ? 18 : 0;

            /* Nœud avec dégradé radial (V1) */
            ctx.beginPath(); ctx.arc(nx, ny, radius, 0, Math.PI*2);
            ctx.fillStyle   = makeGradient({x:nx, y:ny, type:n.type}, radius);
            ctx.fill();
            ctx.strokeStyle = STROKE[n.type];
            ctx.lineWidth   = hov ? 2.5 : 1.5;
            ctx.stroke();
            ctx.shadowBlur = 0;

            /* ── Labels intérieurs pour tous les nœuds ──────────────────── */
            const isPlante = n.type === 'plante';
            const fs = isPlante ? 13 : (radius > 38 ? 10 : 9);
            ctx.font         = (isPlante ? '600' : '500') + ' ' + fs + 'px Inter,sans-serif';
            ctx.fillStyle    = TEXT;
            ctx.textAlign    = 'center';
            ctx.textBaseline = 'middle';

            /* Largeur max = ~90% du diamètre */
            const maxW  = radius * 1.8;
            const words = n.nom.split(' ');
            const lines = [];
            let cur = '';
            words.forEach(w => {
                const t = cur ? cur + ' ' + w : w;
                if (ctx.measureText(t).width > maxW && cur) {
                    lines.push(cur); cur = w;
                } else { cur = t; }
            });
            if (cur) lines.push(cur);
            /* Max 3 lignes avec troncature */
            if (lines.length > 3) { lines[2] = lines[2].slice(0, -1) + '…'; lines.length = 3; }

            const lh = fs + 2.5;
            const sy = ny - (lines.length - 1) * lh / 2;
            lines.forEach((l, i) => ctx.fillText(l, nx, Math.round(sy + i * lh)));
            ctx.globalAlpha = 1;
        });
    }

    /* ── Boucle d'animation (A1) — ease-out cubic ────────────────────── */
    function animate(ts) {
        if (!animStart) animStart = ts;
        progress = Math.min((ts - animStart) / ANIM_DUR, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        draw(eased);
        if (progress < 1) requestAnimationFrame(animate);
    }

    /* ── Hit test ────────────────────────────────────────────────────── */
    function hit(ex, ey) {
        const rect = canvas.getBoundingClientRect();
        const mx = ex - rect.left, my = ey - rect.top;
        return nodes.find(n => Math.hypot(mx-n.x, my-n.y) < n.r+8) || null;
    }

    /* ── Tooltip ─────────────────────────────────────────────────────── */
    function showTooltip(n, cx, cy) {
        if (!n) { tooltip.style.display='none'; return; }
        const rect = canvas.getBoundingClientRect();
        tooltip.textContent   = n.nom;
        tooltip.style.display = 'block';
        tooltip.style.left    = (cx - rect.left + 14)+'px';
        tooltip.style.top     = (cy - rect.top  - 10)+'px';
    }

    /* ── Événements desktop ──────────────────────────────────────────── */
    canvas.addEventListener('mousemove', e => {
        hovered = hit(e.clientX, e.clientY);
        canvas.style.cursor = hovered?.url ? 'pointer' : 'default';
        showTooltip(hovered, e.clientX, e.clientY);
        draw(1);
    });
    canvas.addEventListener('mouseleave', () => {
        hovered = null;
        tooltip.style.display = 'none';
        draw(1);
    });
    canvas.addEventListener('click', e => {
        const n = hit(e.clientX, e.clientY);
        if (n?.url) window.location.href = n.url;
    });

    /* ── Événements touch (M1 : 1er tap = tooltip, 2e = navigation) ─── */
    canvas.addEventListener('touchstart', e => {
        e.preventDefault();
        const t = e.touches[0];
        const n = hit(t.clientX, t.clientY);
        if (!n) { tapped = null; tooltip.style.display='none'; draw(1); return; }
        if (tapped === n && n.url) {
            window.location.href = n.url;
        } else {
            tapped = n; hovered = n;
            showTooltip(n, t.clientX, t.clientY);
            draw(1);
        }
    }, { passive:false });

    window.addEventListener('resize', resize);
    /* Détecte le changement de DPR (zoom navigateur) */
    const watchDpr = () => {
        window.matchMedia(`(resolution: ${dpr()}dppx)`)
              .addEventListener('change', () => { resize(); watchDpr(); }, { once: true });
    };
    watchDpr();
    resize();
})();
</script>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
