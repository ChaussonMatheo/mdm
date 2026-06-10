<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @PwaHead
        <!-- Apple Touch Icons -->
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('apple-touch-icon/apple-touch-icon-57.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('apple-touch-icon/apple-touch-icon-76.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('apple-touch-icon/apple-touch-icon-120.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('apple-touch-icon/apple-touch-icon-152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon/apple-touch-icon-180.png') }}">
        <!-- Apple Splash Screens -->
        <link rel="apple-touch-startup-image" media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="{{ asset('splash/apple-splash-640x1136.png') }}">
        <link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" href="{{ asset('splash/apple-splash-750x1334.png') }}">
        <link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)" href="{{ asset('splash/apple-splash-1242x2208.png') }}">
        <link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" href="{{ asset('splash/apple-splash-1125x2436.png') }}">
        <link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" href="{{ asset('splash/apple-splash-828x1792.png') }}">
        <link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" href="{{ asset('splash/apple-splash-1242x2688.png') }}">
        <link rel="apple-touch-startup-image" media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3)" href="{{ asset('splash/apple-splash-1170x2532.png') }}">
        <link rel="apple-touch-startup-image" media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3)" href="{{ asset('splash/apple-splash-1284x2778.png') }}">
        <link rel="apple-touch-startup-image" media="screen and (device-width: 430px) and (device-height: 932px) and (-webkit-device-pixel-ratio: 3)" href="{{ asset('splash/apple-splash-1290x2796.png') }}">
        <link rel="apple-touch-startup-image" media="screen and (device-width: 440px) and (device-height: 956px) and (-webkit-device-pixel-ratio: 3)" href="{{ asset('splash/apple-splash-1320x2868.png') }}">
        <link rel="apple-touch-startup-image" media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" href="{{ asset('splash/apple-splash-1536x2048.png') }}">
        <link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" href="{{ asset('splash/apple-splash-1668x2224.png') }}">
        <link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" href="{{ asset('splash/apple-splash-1668x2388.png') }}">
        <link rel="apple-touch-startup-image" media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" href="{{ asset('splash/apple-splash-2048x2732.png') }}">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-white dark:bg-gray-950">
            @empty($header)
            <!-- Header -->
            <header class="bg-white dark:bg-gray-900 pt-14 mx-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <!-- Header Left (Logo or Custom Content) -->
                        <div class="flex-shrink-0">
                            {{ $headerLeft ?? '' }}
                            @empty($headerLeft)
                                <img src="{{ asset('logo/LOGO-10.png') }}" alt="{{ config('app.name') }}" class="h-20 w-auto">
                            @endempty
                        </div>
                        <!-- Settings Icon -->
                        <a href="{{ route('settings.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            <i data-lucide="settings" class="w-8 h-8"></i>
                        </a>
                    </div>
                </div>
            </header>
            @endempty

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto px-8 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>
         @RegisterServiceWorkerScript
    </body>
</html>
