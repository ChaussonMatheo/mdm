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
                        <button class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            <i data-lucide="settings" class="w-8 h-8"></i>
                        </button>
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
