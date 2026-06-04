@props(['colors' => ['skin' => '#f5a57f', 'secondary' => '#faea2f', 'accent' => '#f2969f', 'hair' => '#2d2d2d'], 'size' => 'w-48 h-auto', 'style' => 'Perso-28'])

@php
    $skin = $colors['skin'] ?? '#f5a57f';
    $secondary = $colors['secondary'] ?? '#faea2f';
    $accent = $colors['accent'] ?? '#f2969f';
    $hair = $colors['hair'] ?? '#2d2d2d';
    $inlineStyle = "--skin: $skin; --secondary: $secondary; --accent: $accent; --hair: $hair;";

    $svgPath = resource_path("svg/visage/{$style}.svg");
    $svgContent = file_exists($svgPath) ? file_get_contents($svgPath) : '';
@endphp

<div class="w-full h-auto">
    @if($svgContent)
        <div {{ $attributes->merge(['class' => $size . ' mx-auto', 'style' => $inlineStyle]) }}>
            {!! str_replace('<svg', '<svg style="width:100%;height:auto;max-width:200px"', $svgContent) !!}
        </div>
    @else
        <div class="text-gray-400 p-4 text-center">Style non trouvé</div>
    @endif
</div>
