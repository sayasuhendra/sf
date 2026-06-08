@php
    $ft = \App\Models\FrontendText::first();
@endphp
<nav class="navbar">
    <div class="container nav-container">
        <a href="{{ route('home') }}" class="nav-logo">
            {{ $ft->navbar['brand_1'] ?? 'Sekolah' }} {{ $ft->navbar['brand_2'] ?? 'Raheela' }}
        </a>
        <div class="nav-links">
            <a href="#about">{{ $ft->navbar['menu_1'] ?? 'Mengapa' }}</a>
            <a href="#pillars">{{ $ft->navbar['menu_2'] ?? 'Pilar' }}</a>
            <a href="#program">{{ $ft->navbar['menu_3'] ?? 'Program' }}</a>
            <a href="#sponsor">{{ $ft->navbar['menu_4'] ?? 'Sponsor' }}</a>
            <a href="{{ route('game') }}" class="nav-game-link">Game 🎮</a>
        </div>
        <div class="mobile-menu-btn">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu">
    <div class="mobile-nav-links">
        <a href="#about">{{ $ft->navbar['menu_1'] ?? 'Mengapa' }}</a>
        <a href="#pillars">{{ $ft->navbar['menu_2'] ?? 'Pilar' }}</a>
        <a href="#program">{{ $ft->navbar['menu_3'] ?? 'Program' }}</a>
        <a href="#sponsor">{{ $ft->navbar['menu_4'] ?? 'Sponsor' }}</a>
        <a href="{{ route('game') }}">Game 🎮</a>
    </div>
</div>