<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ministère de Mamie') }} — Le jeu pour décider ensemble</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php
    $appUrl = auth()->check() ? url('/dashboard') : (\Illuminate\Support\Facades\Route::has('login') ? route('login') : url('/'));
@endphp

<body id="top" class="bg-[#FDFDFC] text-[#1B1B18] antialiased selection:bg-[#FAEA2F] selection:text-[#1B1B18]">

    {{-- ───────────────────────── HEADER / NAV ───────────────────────── --}}
    <header class="relative border-b border-[#1B1B18]/10">
        <div class="mx-auto flex max-w-[1240px] items-stretch justify-between px-5 sm:px-8">
            {{-- Logo --}}
            <a href="#top" class="flex items-center gap-3 py-4">
                <img src="{{ asset('logo/LOGO-10.png') }}" alt="Ministère de Mamie" class="h-10 w-auto">
            </a>
            {{-- Navigation --}}
            <nav class="flex items-center gap-6 text-[12px] font-medium uppercase tracking-[0.14em]">
                <a href="#top" class="hidden text-[#1B1B18] transition-colors hover:text-[#E6066B] sm:inline">Accueil</a>
                <a href="#regles" class="hidden text-[#1B1B18] transition-colors hover:text-[#E6066B] sm:inline">Règles</a>
                <a href="#points" class="hidden text-[#1B1B18] transition-colors hover:text-[#E6066B] md:inline">Points de vente</a>
                <a href="#contact" class="hidden text-[#1B1B18] transition-colors hover:text-[#E6066B] sm:inline">Contact</a>
                <a href="{{ $appUrl }}" class="bg-[#E6066B] px-4 py-1.5 text-white transition-colors hover:bg-[#c40059]">App</a>
            </nav>
        </div>
    </header>

    {{-- ───────────────────────── HERO ───────────────────────── --}}
    <section class="grid lg:grid-cols-2">
        {{-- Panneau magenta --}}
        <div class="relative bg-[#E6066B] px-6 py-14 sm:px-10 lg:px-14 lg:py-20">
            <p class="mb-6 flex items-center gap-3 text-[12px] font-medium uppercase tracking-[0.2em] text-white">
                <span class="h-px w-7 bg-[#FAEA2F]"></span> Le jeu de famille
            </p>

            <h1 class="roundedfont text-[2.6rem] leading-[0.95] text-white sm:text-6xl lg:text-[4.25rem]">
                Le jeu pour<br>agir pas à pas,<br><span class="text-[#1B1B18]">ensemble</span>
            </h1>

            <p class="mt-8 max-w-md text-[15px] font-medium leading-relaxed text-white/95">
                Ministère de Mamie aide votre famille à organiser, discuter et décider ensemble
                de l'accompagnement d'un proche en perte d'autonomie.
            </p>

            <div class="mt-10 flex flex-wrap items-center gap-6">
                <a href="#points" class="bg-[#1B1B18] px-8 py-4 text-[13px] font-medium uppercase tracking-[0.12em] text-white transition-transform hover:scale-[1.02]">
                    Où l'acheter
                </a>
                <a href="{{ $appUrl }}" class="text-[13px] font-medium uppercase tracking-[0.12em] text-white underline decoration-[#FAEA2F] decoration-2 underline-offset-4 transition-colors hover:text-[#FAEA2F]">
                    Voir l'application
                </a>
            </div>
        </div>

        {{-- Panneau jaune --}}
        <div class="relative min-h-[340px] overflow-hidden bg-[#FAEA2F] lg:min-h-0">
            {{-- Grand cercle magenta débordant en haut à droite --}}
            <div class="absolute -right-20 -top-24 h-72 w-72 rounded-full bg-[#E6066B] sm:h-96 sm:w-96"></div>

            {{-- Légende mascotte --}}
            <div class="absolute left-8 top-1/2 z-10 -translate-y-1/2 text-[14px] font-medium text-[#1B1B18]/80">
                <img src="{{ asset('logo/LOGO-09.png') }}" alt="">
            </div>
            <div class="absolute bottom-10 left-64 h-28 w-28 -translate-x-1/2 rounded-full border-4 border-[#1B1B18] sm:h-36 sm:w-36"></div>


            {{-- Cercle contour --}}
        </div>
    </section>

    {{-- ───────────────────────── 01 — LE CONCEPT ───────────────────────── --}}
    <section class="bg-[#F4F1EA] px-6 py-16 sm:px-10 lg:px-14 lg:py-24">
        <div class="mx-auto grid max-w-[1240px] gap-12 lg:grid-cols-2 lg:gap-16">
            <div>
                <p class="mb-4 text-[12px] font-medium uppercase tracking-[0.2em] text-[#E6066B]">01 — Le concept</p>
                <h2 class="roundedfont text-4xl leading-[0.95] text-[#1B1B18] sm:text-5xl">
                    Un jeu, une appli,<br>une famille réunie
                </h2>
            </div>

            <div class="divide-y divide-[#1B1B18]/10">
                @foreach ([
                    ['01', 'Un jeu de cartes', 'Cartes Vote, Module et Ministère pour structurer chaque discussion familiale autour d\'un sujet du quotidien.', 'bg-[#E6066B] text-white'],
                    ['02', 'Une application', 'Les proches éloignés participent en direct : ils votent, débattent et suivent la partie comme s\'ils étaient à table.', 'bg-[#6C5CE7] text-white'],
                    ['03', 'Une décision collective', 'Chaque membre repart avec un rôle clair, un « ministère », pour répartir la charge mentale équitablement.', 'bg-[#1B1B18] text-[#FAEA2F]'],
                ] as [$num, $title, $text, $badge])
                    <div class="flex gap-5 py-6 first:pt-0">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-[13px] font-medium {{ $badge }}">{{ $num }}</span>
                        <div>
                            <h3 class="text-[14px] font-medium uppercase tracking-[0.08em] text-[#1B1B18]">{{ $title }}</h3>
                            <p class="mt-2 text-[14px] leading-relaxed text-[#1B1B18]/70">{{ $text }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ───────────────────────── 02 — LES RÈGLES ───────────────────────── --}}
    <section id="regles" class="bg-[#161311] px-6 py-16 sm:px-10 lg:px-14 lg:py-24">
        <div class="mx-auto max-w-[1240px]">
            <div class="flex flex-col gap-10 sm:flex-row sm:items-start sm:justify-between">
                <h2 class="roundedfont text-4xl leading-[0.95] text-white sm:text-5xl">
                    Les règles<br>en bref
                </h2>

                <div class="flex gap-8">
                    @foreach ([['2—9', 'Joueurs'], ['20—45', 'Minutes'], ['18', 'Modules']] as [$stat, $label])
                        <div>
                            <p class="roundedfont text-2xl text-[#FAEA2F] sm:text-3xl">{{ $stat }}</p>
                            <p class="mt-1 text-[11px] font-medium uppercase tracking-[0.15em] text-white/60">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-14 divide-y divide-white/10 border-t border-white/10">
                @foreach ([
                    ['Étape 1', 'Sujet', 'Déterminez ensemble la décision à prendre aujourd\'hui : aménagement, intervenant, visites, budget…'],
                    ['Étape 2', 'Vote', 'Chacun choisit sa carte couleur, face cachée. On révèle, on débat, on dégage un consensus collectif.'],
                    ['Étape 3', 'Ministère', 'Répartissez les rôles selon vos envies et disponibilités. Notez-les sur les cartes ou synchronisez dans l\'app.'],
                ] as [$step, $title, $text])
                    <div class="grid items-center gap-4 py-7 sm:grid-cols-[160px_1fr_2fr]">
                        <span class="w-fit rounded-full border border-[#E6066B] px-4 py-1.5 text-[11px] font-medium uppercase tracking-[0.15em] text-[#E6066B]">{{ $step }}</span>
                        <h3 class="roundedfont text-2xl uppercase text-[#FAEA2F]">{{ $title }}</h3>
                        <p class="text-[14px] leading-relaxed text-white/70">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ───────────────────────── 03 — POINTS DE VENTE ───────────────────────── --}}
    <section id="points" class="bg-[#FDFDFC] px-6 py-16 sm:px-10 lg:px-14 lg:py-24">
        <div class="mx-auto max-w-[1240px]">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <h2 class="roundedfont text-4xl leading-[0.95] text-[#1B1B18] sm:text-5xl">
                    Disponible<br>près de chez<br>vous
                </h2>
                <p class="text-[12px] font-medium uppercase tracking-[0.2em] text-[#1B1B18]/50">03 — Où nous trouver</p>
            </div>

            <div class="mt-12 grid border border-[#1B1B18]/15 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-dashed divide-[#1B1B18]/20">
                @foreach ([
                    ['Pharmacie', 'En officine', 'Le jeu sera proposé dans une sélection de pharmacies partenaires, au plus près des familles aidantes.'],
                    ['Librairie', 'En point culturel', 'Retrouvez Ministère de Mamie dans des librairies et points culturels partenaires.'],
                    ['En ligne', 'Boutique web', 'Commandez directement votre boîte de jeu depuis notre boutique en ligne.'],
                ] as [$eyebrow, $title, $text])
                    <div class="flex flex-col p-7">
                        <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-[#1B1B18]/40">— {{ $eyebrow }}</p>
                        <h3 class="mt-4 text-[16px] font-medium text-[#1B1B18]">{{ $title }}</h3>
                        <p class="mt-3 flex-1 text-[14px] leading-relaxed text-[#1B1B18]/70">{{ $text }}</p>
                        <span class="mt-6 w-fit rounded-full border border-[#1B1B18] px-4 py-2 text-[11px] font-medium uppercase tracking-[0.12em] text-[#1B1B18]">Bientôt disponible</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ───────────────────────── 04 — L'APPLICATION ───────────────────────── --}}
    <section id="app" class="grid lg:grid-cols-2">
        {{-- Panneau magenta --}}
        <div class="bg-[#E6066B] px-6 py-16 sm:px-10 lg:px-14 lg:py-24">
            <p class="mb-5 text-[12px] font-medium uppercase tracking-[0.2em] text-white/80">04 — L'application</p>
            <h2 class="roundedfont text-4xl leading-[0.95] text-white sm:text-5xl">
                Restez connectés au<br>conseil des ministres
            </h2>
            <p class="mt-8 max-w-md text-[15px] font-medium leading-relaxed text-white/95">
                Incluez vos proches éloignés dans la partie : ils votent, débattent et suivent les décisions
                en direct, où qu'ils soient. Pas de magasin d'applications — installez-la directement depuis
                votre navigateur.
            </p>
        </div>

        {{-- Panneau clair : étapes d'installation PWA --}}
        <div class="bg-[#F4F1EA] px-6 py-16 sm:px-10 lg:px-14 lg:py-24">
            <ol class="space-y-5">
                @foreach ([
                    ['Ouvrez le site', ' sur votre téléphone, dans Safari ou Chrome'],
                    ['Appuyez sur Partager', ' (iOS) ou le menu (Android)'],
                    ['Sélectionnez « Sur l\'écran d\'accueil »', ' — c\'est prêt'],
                ] as $i => [$strong, $rest])
                    <li class="flex items-start gap-4">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-[#E6066B] text-[11px] font-medium text-[#E6066B]">0{{ $i + 1 }}</span>
                        <p class="text-[14px] leading-relaxed text-[#1B1B18]/80"><span class="font-semibold text-[#1B1B18]">{{ $strong }}</span>{{ $rest }}</p>
                    </li>
                @endforeach
            </ol>

            <a href="{{ $appUrl }}" class="mt-10 flex items-center justify-between border border-[#1B1B18] px-6 py-4 text-[13px] font-medium uppercase tracking-[0.12em] text-[#1B1B18] transition-colors hover:bg-[#1B1B18] hover:text-white">
                Ajouter à l'écran d'accueil
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </section>

    {{-- ───────────────────────── NOTE PROJET ───────────────────────── --}}
    <section id="contact" class="bg-[#FDFDFC] px-6 py-12">
        <p class="mx-auto max-w-xl text-center text-[12px] leading-relaxed text-[#1B1B18]/55">
            <span class="font-semibold text-[#1B1B18]">Ministère de Mamie</span> est un projet de fin d'études
            (DNMADE 3) conçu et développé par Yuna Le Grand. Ce site présente un projet en cours de
            développement, à des fins de communication et de recherche d'opportunités.
        </p>
    </section>

    {{-- ───────────────────────── FOOTER ───────────────────────── --}}
    <footer class="bg-[#161311] px-6 py-6 sm:px-10 lg:px-14">
        <div class="mx-auto flex max-w-[1240px] flex-col items-center gap-2 text-center sm:flex-row sm:justify-between sm:text-left">
            <p class="roundedfont text-sm uppercase tracking-[0.1em] text-white">
                Ministère <span class="text-[#FAEA2F]">de Mamie</span>
            </p>
            <p class="text-[11px] uppercase tracking-[0.12em] text-white/50">2026 — Projet DNMADE 3 — Yuna Le Grand</p>
        </div>
    </footer>

</body>
</html>
