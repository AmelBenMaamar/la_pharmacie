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

            'categorie' => <<<SVG
            <svg class="{$cls}" width="{$s}" height="{$s}" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M3 7C3 5.9 3.9 5 5 5H10L12 7H19C20.1 7 21 7.9 21 9V18C21 19.1 20.1 20 19 20H5C3.9 20 3 19.1 3 18V7Z"
                      fill="currentColor" opacity="0.12"
                      stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                <path d="M3 11H21" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" opacity="0.4"/>
            </svg>
            SVG,

            'lien' => <<<SVG
            <svg class="{$cls}" width="{$s}" height="{$s}" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"
                      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"
                      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            SVG,

            'edit' => <<<SVG
            <svg class="{$cls}" width="{$s}" height="{$s}" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M11 4H4C3.46 4 2.94 4.21 2.59 4.59C2.21 4.96 2 5.47 2 6V20C2 20.53 2.21 21.04 2.59 21.41C2.96 21.79 3.47 22 4 22H18C19.1 22 20 21.1 20 20V13"
                      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5Z"
                      fill="currentColor" opacity="0.15"
                      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            SVG,

            'save' => <<<SVG
            <svg class="{$cls}" width="{$s}" height="{$s}" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M19 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3H16L21 8V19C21 20.1 20.1 21 19 21Z"
                      fill="currentColor" opacity="0.1"
                      stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                <path d="M17 21V13H7V21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M7 3V8H15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            SVG,

            'close' => <<<SVG
            <svg class="{$cls}" width="{$s}" height="{$s}" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            SVG,

            default => ''
        };
    }
}
