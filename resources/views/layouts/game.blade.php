<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="theme-color" content="#0f172a" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <title>@yield('title', 'Raheela Game Suite')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/game.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #020617; /* slate-950 */
            color: #f8fafc;
            overscroll-behavior-y: none; /* Prevent pull-to-refresh on mobile */
            -webkit-tap-highlight-color: transparent;
        }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="antialiased overflow-hidden w-full h-screen fixed inset-0">
    <div class="h-full w-full max-w-md mx-auto relative bg-slate-900 overflow-hidden shadow-2xl flex flex-col">
        {{ $slot }}
    </div>
    

    @livewireScripts
    @stack('scripts')
</body>
</html>
