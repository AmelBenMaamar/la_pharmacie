<?php
if (!function_exists('icon')) {
    function icon(string $name, int $size = 20, string $class = ''): string {
        $cls = 'svg-icon' . ($class ? ' ' . $class : '');
        $s   = $size;
        return match($name) {

            'plante' => <<<SVG
            <svg class="{$cls}" width="{$s}" height="{$s}" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M12 22C12 22 4 16 4 9C4 5.13 7.58 2 12 2C16.42 2 20 5.13 20 9C20 16 12 22 12 22Z"
                      fill="currentColor" opacity="0.15"/>
                <path d="M12 22C12 22 4 16 4 9C4 5.13 7.58 2 12 2C16.42 2 20 5.13 20 9C20 16 12 22 12 22Z"
                      stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                <path d="M12 22V10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M12 16C12 16 8 13 8 9" stroke="currentColor" stroke-width="1.2"
                      stroke-linecap="round" opacity="0.5"/>
            </svg>
            SVG,

            'composant' => <<<SVG
            <svg class="{$cls}" width="{$s}" height="{$s}" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <polygon points="12,3 20,7.5 20,16.5 12,21 4,16.5 4,7.5"
                         fill="currentColor" opacity="0.1"
                         stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                <circle cx="12" cy="12" r="2.5" fill="currentColor"/>
                <line x1="12" y1="3"    x2="12" y2="9.5"    stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                <line x1="12" y1="14.5" x2="12" y2="21"     stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                <line x1="4"  y1="7.5"  x2="9.8" y2="10.7"  stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                <line x1="14.2" y1="13.3" x2="20" y2="16.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                <line x1="20" y1="7.5"  x2="14.2" y2="10.7" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                <line x1="9.8" y1="13.3" x2="4"  y2="16.5"  stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
            SVG,

            'vertu' => <<<SVG
            <svg class="{$cls}" width="{$s}" height="{$s}" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M12 2C12 2 13.5 7 18 8C18 8 13.5 9 12 14C12 14 10.5 9 6 8C6 8 10.5 7 12 2Z"
                      fill="currentColor" opacity="0.25" stroke="currentColor" stroke-width="1.3"
                      stroke-linejoin="round"/>
                <path d="M12 14C12 14 13 17.5 16 18.5C16 18.5 13 19.5 12 23C12 23 11 19.5 8 18.5C8 18.5 11 17.5 12 14Z"
                      fill="currentColor" opacity="0.2" stroke="currentColor" stroke-width="1.1"
                      stroke-linejoin="round"/>
            </svg>
            SVG,

            default => ''
        };
    }
}
