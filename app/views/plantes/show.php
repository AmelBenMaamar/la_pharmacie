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
    const APP_URL   = '<?= APP_URL ?>';
    const planteNom = '<?= addslashes($plante['nom']) ?>';
    const composants = <?= json_encode(array_map(fn($c) => ['nom'=>$c['nom'],'slug'=>$c['slug']], $composants)) ?>;
    const vertus     = <?= json_encode(array_map(fn($v) => ['nom'=>$v['nom'],'slug'=>$v['slug']], $vertus)) ?>;

    const FILL   = { plante:'#DCFCF2', composant:'#E8DCFC', vertu:'#F9FCDC' };
    const STROKE = { plante:'#a0ead8', composant:'#c4a0e8', vertu:'#d8e8a0' };
    const TEXT   = '#044B71';
    const LINE   = '#D4C8B8';
    const BG     = '#F5F0E8';

    const canvas  = document.getElementById('graphe-canvas');
    const tooltip = document.getElementById('graphe-tooltip');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const dpr = () => window.devicePixelRatio || 1;
    let nodes = [], hovered = null, W = 0, H = 0;

    /* ─── Resize ──────────────────────────────────────────────────────── */
    function resize() {
        W = canvas.parentElement.offsetWidth;
        H = Math.max(460, Math.min(620, W * 0.62));

        /* buffer physique */
        canvas.width  = Math.round(W * dpr());
        canvas.height = Math.round(H * dpr());

        /* taille CSS = ce que l'œil voit */
        canvas.style.width  = W + 'px';
        canvas.style.height = H + 'px';

        buildNodes();
        draw();
    }

    /* ─── Nœuds ───────────────────────────────────────────────────────── */
    function buildNodes() {
        nodes = [];
        // W forcé pair pour éviter cx = X.5
        if (W % 2 !== 0) W--;
        if (H % 2 !== 0) H--;
        const cx = Math.round(W / 2), cy = Math.round(H / 2);
        const base = Math.min(W, H) * 0.44;
        const r1 = base * 0.38, r2 = base * 0.80;
        const rC = Math.max(30, Math.min(44, 180 / Math.max(composants.length, 1)));
        const rV = Math.max(26, Math.min(38, 180 / Math.max(vertus.length,    1)));

        nodes.push({ nom: planteNom, type:'plante', x:cx, y:cy, r:46, url:null });

        composants.forEach((c, i) => {
            const a = 2*Math.PI*i/Math.max(composants.length,1) - Math.PI/2;
            nodes.push({ ...c, type:'composant',
                         x: Math.round(cx + r1*Math.cos(a)),
                         y: Math.round(cy + r1*Math.sin(a)),
                         r:rC, url: APP_URL+'/composants/'+c.slug });
        });

        vertus.forEach((v, i) => {
            const a = 2*Math.PI*i/Math.max(vertus.length,1) - Math.PI/2;
            nodes.push({ ...v, type:'vertu',
                         x: Math.round(cx + r2*Math.cos(a)),
                         y: Math.round(cy + r2*Math.sin(a)),
                         r:rV, url: APP_URL+'/vertus/'+v.slug });
        });
    }

    /* ─── Texte multiligne ────────────────────────────────────────────── */
    function wrapText(text, maxW) {
        const words = text.split(' ');
        const lines = [];
        let cur = '';
        words.forEach(w => {
            const t = cur ? cur+' '+w : w;
            if (ctx.measureText(t).width > maxW - 8) { if (cur) lines.push(cur); cur = w; }
            else cur = t;
        });
        if (cur) lines.push(cur);
        if (lines.length > 2) { lines[1] = lines[1].slice(0,-1)+'…'; return lines.slice(0,2); }
        return lines;
    }

    /* ─── Draw ────────────────────────────────────────────────────────── */
    function draw() {
        /*
         * setTransform au début de CHAQUE draw()
         * canvas.width reset le contexte → on doit reposer le scale ici,
         * pas dans resize() où il serait perdu dès le prochain redraw.
         */
        ctx.setTransform(dpr(), 0, 0, dpr(), 0, 0);
        ctx.clearRect(0, 0, W, H);

        /* fond */
        ctx.fillStyle = BG;
        ctx.beginPath(); ctx.roundRect(0, 0, W, H, 14); ctx.fill();

        if (!nodes.length) return;
        const center = nodes[0];

        /* lignes composants (pleines) */
        ctx.setLineDash([]);
        ctx.strokeStyle = LINE;
        ctx.lineWidth   = 1.5;
        nodes.slice(1, 1+composants.length).forEach(n => {
            ctx.beginPath(); ctx.moveTo(center.x, center.y); ctx.lineTo(n.x, n.y); ctx.stroke();
        });

        /* lignes vertus (pointillés) */
        ctx.setLineDash([5, 4]);
        ctx.lineWidth = 1;
        nodes.slice(1+composants.length).forEach(n => {
            ctx.beginPath(); ctx.moveTo(center.x, center.y); ctx.lineTo(n.x, n.y); ctx.stroke();
        });
        ctx.setLineDash([]);

        /* nœuds */
        nodes.forEach(n => {
            const hov = hovered === n;
            const r   = hov ? n.r + 4 : n.r;

            ctx.shadowColor = hov ? FILL[n.type] : 'transparent';
            ctx.shadowBlur  = hov ? 16 : 0;

            ctx.beginPath(); ctx.arc(n.x, n.y, r, 0, Math.PI*2);
            ctx.fillStyle   = FILL[n.type]; ctx.fill();
            ctx.strokeStyle = STROKE[n.type];
            ctx.lineWidth   = hov ? 2.5 : 1.5; ctx.stroke();
            ctx.shadowBlur  = 0;

            /* texte */
            const fs = n.type === 'plante' ? 12 : 10;
            ctx.font         = (n.type==='plante'?'600':'500')+' '+fs+'px Inter,sans-serif';
            ctx.fillStyle    = TEXT;
            ctx.textAlign    = 'center';
            ctx.textBaseline = 'middle';
            const lines = wrapText(n.nom, r*2);
            const lh    = fs + 3;
            const sy    = n.y - (lines.length-1)*lh/2;
            lines.forEach((l, i) => ctx.fillText(l, Math.round(n.x), Math.round(sy+i*lh)));
        });
    }

    /* ─── Événements ──────────────────────────────────────────────────── */
    function hit(ex, ey) {
        /* ex/ey en CSS px → même espace que nodes */
        const rect = canvas.getBoundingClientRect();
        const mx = ex - rect.left, my = ey - rect.top;
        return nodes.find(n => Math.hypot(mx-n.x, my-n.y) < n.r+6) || null;
    }

    canvas.addEventListener('mousemove', e => {
        hovered = hit(e.clientX, e.clientY);
        canvas.style.cursor = hovered?.url ? 'pointer' : 'default';
        if (hovered) {
            const rect = canvas.getBoundingClientRect();
            tooltip.textContent   = hovered.nom;
            tooltip.style.display = 'block';
            tooltip.style.left    = (e.clientX - rect.left + 14)+'px';
            tooltip.style.top     = (e.clientY - rect.top  - 10)+'px';
        } else {
            tooltip.style.display = 'none';
        }
        draw();
    });

    canvas.addEventListener('mouseleave', () => {
        hovered = null; tooltip.style.display = 'none'; draw();
    });

    canvas.addEventListener('click', e => {
        const n = hit(e.clientX, e.clientY);
        if (n?.url) window.location.href = n.url;
    });

    canvas.addEventListener('touchstart', e => {
        e.preventDefault();
        const t = e.touches[0];
        const n = hit(t.clientX, t.clientY);
        if (n?.url) window.location.href = n.url;
    }, { passive:false });

    window.addEventListener('resize', resize);
    resize();
})();
</script>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
