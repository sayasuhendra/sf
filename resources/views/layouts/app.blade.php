<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="School Fair 2026 - Suara Nurani Bangsa. Mari Membesarkan Generasi Dengan Hati." />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Suara Nurani Bangsa | School Fair 2026')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Outfit:wght@100..900&display=swap"
        rel="stylesheet">

    <!-- Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/css/glightbox.min.css" />

    @livewireStyles
    @stack('styles')
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader-content">
            <div class="loader-logo">Sekolah Raheela</div>
            <div class="loader-bar">
                <div class="loader-progress"></div>
            </div>
        </div>
    </div>

    <!-- Floating WA (Keep for Sekolah Raheela contact if needed, or remove) -->
    {{-- @include('layouts.partials.wa-float') --}}

    <!-- Navbar -->
    @include('layouts.partials.navbar')

    <!-- Main Content -->
    {{ $slot }}

    <!-- Footer -->
    @include('layouts.partials.footer')

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    
    @livewireScripts
    @stack('scripts')
</body>

</html>