@props(['colors' => ['skin' => '#f5a57f', 'secondary' => '#faea2f', 'accent' => '#f2969f', 'hair' => '#2d2d2d'], 'size' => 'w-48', 'style' => ['face' => 'Perso-18', 'features' => 'Perso-23', 'hair' => 'Perso-28']])

@php
    $skin = $colors['skin'] ?? '#f5a57f';
    $secondary = $colors['secondary'] ?? '#faea2f';
    $accent = $colors['accent'] ?? '#f2969f';
    $hair = $colors['hair'] ?? '#2d2d2d';
    $cssVars = "--skin: $skin; --secondary: $secondary; --accent: $accent; --hair: $hair;";

    $basePath = resource_path('svg/visage');

    $faceSvg = file_exists("{$basePath}/{$style['face']}.svg") ? file_get_contents("{$basePath}/{$style['face']}.svg") : '';
    $featuresSvg = file_exists("{$basePath}/{$style['features']}.svg") ? file_get_contents("{$basePath}/{$style['features']}.svg") : '';
    $hairSvg = file_exists("{$basePath}/{$style['hair']}.svg") ? file_get_contents("{$basePath}/{$style['hair']}.svg") : '';

    // Extraire uniquement le contenu entre les balises <svg> et </svg> (sans <svg ...>)
    $extractBody = function($svg) {
        preg_match('/<svg[^>]*>(.*?)<\/svg>/s', $svg, $match);
        return str_replace('<defs>', '<defs class="merged">', $match[1] ?? '');
    };
@endphp

<div {{ $attributes->merge(['class' => $size . ' mx-auto relative', 'style' => $cssVars]) }}>
    <svg viewBox="0 0 271.31 271.31" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:auto;">
        @if($hairSvg)
            {!! $extractBody($hairSvg) !!}
        @endif
        @if($faceSvg)
            {!! $extractBody($faceSvg) !!}
        @endif
        @if($featuresSvg)
            {!! $extractBody($featuresSvg) !!}
        @endif
    </svg>
</div>
