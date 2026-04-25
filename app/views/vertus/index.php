<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<div class="fiche-header">
    <div style="max-width:900px; margin:0 auto;">
        <h1 class="fiche-title">Les Vertus</h1>
        <p style="color:var(--texte-light); margin-top:0.5rem;">
            Explore les propriétés thérapeutiques des plantes
        </p>
    </div>
</div>

<div class="fiche-body">

<?php if (empty($vertus)): ?>
    <p style="color:var(--texte-light); text-align:center; padding:3rem 0;">
        Aucune vertu enregistrée pour le moment.
    </p>
<?php else: ?>

    <div class="wheel-layout">

        <!-- ROUE SVG -->
        <div class="wheel-container">
            <?php
            $palette = [
                'Immunité'               => ['fill' => '#6BD1D6', 'text' => '#1a5558'],
                'Métabolisme'            => ['fill' => '#6B94D6', 'text' => '#1a2d5a'],
                'Fonction physiologique' => ['fill' => '#9B8FD4', 'text' => '#2d1f6e'],
                'Antioxydant'            => ['fill' => '#B5D9A0', 'text' => '#1e4a10'],
                'Digestif'               => ['fill' => '#F5C97A', 'text' => '#6b3a00'],
                'Cardiovasculaire'       => ['fill' => '#F4A0A0', 'text' => '#6a1010'],
                'Détox'                  => ['fill' => '#A0D4F4', 'text' => '#0e3a6a'],
                'default'                => ['fill' => '#B8D4C8', 'text' => '#1a4a35'],
            ];

            $n          = count($vertus);
            $cx         = 200;
            $cy         = 200;
            $rOuter     = 178;
            $rInner     = 70;
            $angleStep  = 360 / $n;
            $startAngle = -90;
            ?>

            <svg class="wheel-svg" viewBox="0 0 400 400"
                 xmlns="http://www.w3.org/2000/svg"
                 role="img" aria-label="Roue des vertus">

                <defs>
                    <filter id="shadow">
                        <feDropShadow dx="0" dy="2" stdDeviation="5"
                                      flood-color="rgba(61,48,40,0.12)"/>
                    </filter>
                    <filter id="shadow-hover">
                        <feDropShadow dx="0" dy="4" stdDeviation="10"
                                      flood-color="rgba(61,48,40,0.22)"/>
                    </filter>
                </defs>

                <?php foreach ($vertus as $i => $v):
                    $angStartDeg = $startAngle + $i * $angleStep;
                    $angEndDeg   = $startAngle + ($i + 1) * $angleStep;
                    $angStart    = deg2rad($angStartDeg);
                    $angEnd      = deg2rad($angEndDeg);

                    $x1  = round($cx + $rOuter * cos($angStart), 3);
                    $y1  = round($cy + $rOuter * sin($angStart), 3);
                    $x2  = round($cx + $rOuter * cos($angEnd),   3);
                    $y2  = round($cy + $rOuter * sin($angEnd),   3);
                    $ix1 = round($cx + $rInner * cos($angStart), 3);
                    $iy1 = round($cy + $rInner * sin($angStart), 3);
                    $ix2 = round($cx + $rInner * cos($angEnd),   3);
                    $iy2 = round($cy + $rInner * sin($angEnd),   3);

                    $largeArc = $angleStep > 180 ? 1 : 0;

                    $d = "M {$ix1} {$iy1} "
                       . "L {$x1} {$y1} "
                       . "A {$rOuter} {$rOuter} 0 {$largeArc} 1 {$x2} {$y2} "
                       . "L {$ix2} {$iy2} "
                       . "A {$rInner} {$rInner} 0 {$largeArc} 0 {$ix1} {$iy1} Z";

                    // Position du label au milieu du segment
                    $angMidDeg = $startAngle + ($i + 0.5) * $angleStep;
                    $angMid    = deg2rad($angMidDeg);
                    $rLabel    = ($rOuter + $rInner) / 2;
                    $lx        = round($cx + $rLabel * cos($angMid), 3);
                    $ly        = round($cy + $rLabel * sin($angMid), 3);

                    // Rotation du texte : toujours lisible (jamais à l'envers)
                    $textRot = $angMidDeg + 90;
                    if ($textRot > 90 && $textRot < 270) $textRot += 180;

                    $cat    = $v['categorie'] ?? 'default';
                    $colors = $palette[$cat] ?? $palette['default'];
                    $label  = htmlspecialchars($v['nom']);
                    $slug   = htmlspecialchars($v['slug']);

                    // Tronquer si trop long
                    $labelShort = mb_strlen($v['nom']) > 18
                        ? mb_substr($v['nom'], 0, 16) . '…'
                        : $v['nom'];
                ?>

                <a href="<?= APP_URL ?>/vertus/<?= $slug ?>"
                   class="wheel-segment-link"
                   aria-label="<?= $label ?>">

                    <path d="<?= $d ?>"
                          class="wheel-segment"
                          fill="<?= $colors['fill'] ?>"
                          filter="url(#shadow)">
                        <title><?= $label ?></title>
                    </path>

                    <text x="<?= $lx ?>"
                          y="<?= $ly ?>"
                          class="wheel-label"
                          fill="<?= $colors['text'] ?>"
                          text-anchor="middle"
                          dominant-baseline="middle"
                          transform="rotate(<?= $textRot ?>, <?= $lx ?>, <?= $ly ?>)"
                          pointer-events="none">
                        <?= htmlspecialchars($labelShort) ?>
                    </text>

                </a>
                <?php endforeach; ?>

                <!-- Cercle central -->
                <circle cx="<?= $cx ?>" cy="<?= $cy ?>"
                        r="<?= $rInner - 3 ?>"
                        fill="var(--creme)"
                        stroke="var(--border)"
                        stroke-width="1.5"/>

                <text x="<?= $cx ?>" y="<?= $cy - 10 ?>"
                      text-anchor="middle"
                      dominant-baseline="middle"
                      class="wheel-center-title"
                      fill="#5C4A32">Vertus</text>

                <text x="<?= $cx ?>" y="<?= $cy + 12 ?>"
                      text-anchor="middle"
                      dominant-baseline="middle"
                      class="wheel-center-count"
                      fill="#A68B5B"><?= $n ?></text>

            </svg>
        </div>

        <!-- LÉGENDE -->
        <div class="wheel-legend">
            <h3 style="margin-bottom:1.25rem; font-family:var(--font-serif);">Explorer</h3>
            <?php foreach ($vertus as $v):
                $cat    = $v['categorie'] ?? 'default';
                $colors = $palette[$cat] ?? $palette['default'];
            ?>
            <a href="<?= APP_URL ?>/vertus/<?= htmlspecialchars($v['slug']) ?>"
               class="wheel-legend-item">
                <span class="wheel-legend-dot"
                      style="background:<?= $colors['fill'] ?>; border-color:<?= $colors['fill'] ?>"></span>
                <span class="wheel-legend-nom"><?= htmlspecialchars($v['nom']) ?></span>
                <?php if (!empty($v['categorie'])): ?>
                    <span class="wheel-legend-cat"><?= htmlspecialchars($v['categorie']) ?></span>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>

    </div>

<?php endif; ?>

</div>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
