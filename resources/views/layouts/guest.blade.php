<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $storeSettings['store_name'] ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="flex flex-col items-center">
                <a href="/">
                    @if(isset($storeSettings['store_icon']) && $storeSettings['store_icon'])
                        <img src="{{ asset('storage/' . $storeSettings['store_icon']) }}" 
                             alt="{{ $storeSettings['store_name'] }}" 
                             class="w-24 h-24 object-contain mb-2">
                    @else
                        <x-application-logo class="w-24 h-24 mb-2" />
                    @endif
                </a>
                <h2 class="text-2xl font-medium text-gray-600 mt-2">
                    {{ $storeSettings['store_name'] ?? 'TOKO BUDI' }}
                </h2>
            </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
