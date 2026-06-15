@props(['colors' => ['skin' => '#f5a57f', 'secondary' => '#faea2f', 'accent' => '#f2969f', 'hair' => '#2d2d2d'], 'size' => 'w-48', 'style' => ['face' => 'Perso-18', 'features' => 'Perso-23', 'hair' => 'Perso-28']])

@php
    $style = is_array($style) ? $style : ['face' => 'Perso-18', 'features' => 'Perso-23', 'hair' => 'Perso-28'];

    $skin = $colors['skin'] ?? '#f5a57f';
    $secondary = $colors['secondary'] ?? '#faea2f';
    $accent = $colors['accent'] ?? '#f2969f';
    $hair = $colors['hair'] ?? '#2d2d2d';
    $cssVars = "--skin: $skin; --secondary: $secondary; --accent: $accent; --hair: $hair;";

    $basePath = resource_path('svg/visage');

    $faceSvg = file_exists("{$basePath}/{$style['face']}.svg") ? file_get_contents("{$basePath}/{$style['face']}.svg") : '';
    $featuresSvg = file_exists("{$basePath}/{$style['features']}.svg") ? file_get_contents("{$basePath}/{$style['features']}.svg") : '';
    $hairSvg = file_exists("{$basePath}/{$style['hair']}.svg") ? file_get_contents("{$basePath}/{$style['hair']}.svg") : '';

    $extractBody = function($svg, $prefix) {
        preg_match('/<svg[^>]*>(.*?)<\/svg>/s', $svg, $match);
        $body = $match[1] ?? '';
        // Prefix class names in CSS rules: .cls-N → .prefix-cls-N
        $body = preg_replace('/\.(cls-\d+)/', '.' . $prefix . '-$1', $body);
        // Prefix class attributes on elements
        $body = preg_replace_callback('/\bclass="([^"]+)"/', function($m) use ($prefix) {
            $classes = preg_replace('/\bcls-(\d+)\b/', $prefix . '-cls-$1', $m[1]);
            return 'class="' . $classes . '"';
        }, $body);
        return str_replace('<defs>', '<defs class="merged">', $body);
    };
@endphp

<div {{ $attributes->merge(['class' => $size . ' mx-auto relative', 'style' => $cssVars]) }}>
    <svg viewBox="0 0 271.31 271.31" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:auto;">
        @if($faceSvg)
            {!! $extractBody($faceSvg, 'f') !!}
        @endif
        @if($featuresSvg)
            {!! $extractBody($featuresSvg, 't') !!}
        @endif
        @if($hairSvg)
            {!! $extractBody($hairSvg, 'h') !!}
        @endif
    </svg>
</div>
