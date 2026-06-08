@php
    $frontendText = \App\Models\FrontendText::first();
    $categories = \App\Models\ProductCategory::withCount('images')->get();
    $projects = \App\Models\Project::latest()->take(6)->get();
@endphp

<div class="smooth-scroll-wrapper">
    <!-- Hero Section -->
    <header class="hero" id="home">
        <video autoplay muted loop playsinline class="hero-video" id="heroVideo" preload="auto">
            <source src="{{ asset('sri.mp4') }}" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <p class="hero-date reveal-hero">
                    {{ $frontendText->hero['date'] ?? 'Sabtu, 27 Juni 2026 | 15.30 — 17.30 WIB' }}</p>
                <h1 class="hero-title reveal-hero">{{ $frontendText->hero['title'] ?? 'Suara Nurani Bangsa' }}</h1>
                <p class="hero-subtitle reveal-hero">{{ $frontendText->hero['subtitle'] ?? 'School Fair 2026' }}</p>
                <div class="hero-motto reveal-hero">
                    <span>"{{ $frontendText->hero['motto'] ?? 'Mari Membesarkan Generasi Dengan Hati' }}"</span>
                </div>
                <div class="hero-cta reveal-hero">
                    <a href="#sponsor"
                        class="btn btn-primary">{{ $frontendText->hero['btn_text'] ?? 'Dukung Kami' }}</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Latar Belakang (About) -->
    <section class="section latar-belakang" id="about">
        <div class="logo-decor logo-decor--left">
            <img src="{{ asset('sekolahraheela.png') }}" alt="" aria-hidden="true">
        </div>
        <div class="container">
            <div class="section-header">
                <h2 class="reveal">{{ $frontendText->about['title'] ?? 'Mengapa School Fair?' }}</h2>
            </div>
            <div class="grid grid-3">
                @if(isset($frontendText->about['items']))
                    @foreach($frontendText->about['items'] as $item)
                        <div class="card reveal">
                            <div class="card-icon">{{ $item['icon'] ?? '✨' }}</div>
                            <h3>{{ $item['title'] ?? '' }}</h3>
                            <p>{{ $item['desc'] ?? '' }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Empat Pilar -->
    <section class="section pilar" id="pillars">
        <div class="container">
            <div class="section-header">
                <h2 class="reveal">{{ $frontendText->pillars['title'] ?? 'Empat Pilar Utama' }}</h2>
            </div>
            <div class="pilar-grid">
                @if(isset($frontendText->pillars['items']))
                    @foreach($frontendText->pillars['items'] as $pilar)
                        <div class="pilar-item">
                            <div class="pilar-number">{{ $pilar['number'] ?? '01' }}</div>
                            <div class="pilar-content">
                                <h3>{{ $pilar['icon'] ?? '' }} {{ $pilar['title'] ?? '' }}</h3>
                                <p>{{ $pilar['desc'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- School Fair Gallery per year -->
    {{-- <section class="section gallery-section" id="gallery">
        <div class="container">
            <div class="section-header">
                <h2 class="reveal">School Fair Gallery</h2>
                <p class="reveal">Momen berharga dari tahun ke tahun</p>
            </div>
            <div class="grid grid-3">
                @foreach($categories as $category)
                <a href="{{ route('product.gallery', $category->slug) }}" class="card reveal"
                    style="text-decoration: none; text-align: center;" wire:navigate>
                    <div class="card-icon">📂</div>
                    <h3>{{ $category->name }}</h3>
                    <p>{{ $category->images_count }} Foto Dokumentasi</p>
                    <div class="btn btn-secondary" style="margin-top: 20px; padding: 10px 20px;">Lihat Galeri</div>
                </a>
                @endforeach
            </div>
        </div>
    </section> --}}

    <!-- Program Acara -->
    <section class="section program" id="program">
        <div class="container">
            <div class="section-header">
                <h2 class="reveal">{{ $frontendText->program['title'] ?? 'Program Acara' }}</h2>
            </div>
            <div class="program-grid">
                @if(isset($frontendText->program['items']))
                    @foreach($frontendText->program['items'] as $prog)
                        <div class="program-card reveal">
                            <div class="program-time">{{ $prog['number'] ?? '01' }}</div>
                            <h3>{{ $prog['title'] ?? '' }}</h3>
                            <p>{{ $prog['desc'] ?? '' }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- School Fair Documentation History -->
    {{-- <section class="section history-section" id="history">
        <div class="container">
            <div class="section-header">
                <h2 class="reveal">Documentation History</h2>
                <p class="reveal">Catatan perjalanan School Fair Sekolah Raheela</p>
            </div>
            <div class="grid grid-3">
                @foreach($projects as $project)
                <a href="{{ route('portfolio.detail', $project->id) }}" class="card reveal"
                    style="text-decoration: none;" wire:navigate>
                    @php
                    $pPhoto = (is_array($project->photos) && isset($project->photos[0])) ? $project->photos[0] : null;
                    $pPhotoUrl = $pPhoto ? (str_starts_with($pPhoto, 'img/') ? asset($pPhoto) : asset('storage/' .
                    $pPhoto)) :
                    'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&q=80';
                    @endphp
                    <div style="height: 200px; border-radius: 15px; overflow: hidden; margin-bottom: 20px;">
                        <img src="{{ $pPhotoUrl }}" alt="{{ $project->title }}"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h3>{{ $project->title }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">{{ $project->category }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section> --}}

    <!-- Sponsorship -->
    <section class="section sponsor" id="sponsor">
        <div class="container">
            <div class="section-header">
                <h2 class="reveal">{{ $frontendText->sponsor['title'] ?? 'Mari Menjadi Bagian dari Perubahan' }}</h2>
                <p class="reveal">
                    {{ $frontendText->sponsor['subtitle'] ?? 'Dukung kami dalam membesarkan generasi dengan hati.' }}
                </p>
            </div>
            <div class="sponsor-cta reveal">
                <div class="cta-box">
                    <img src="{{ asset('sekolahraheela.png') }}" alt="" class="cta-logo" aria-hidden="true">
                    <h3>{{ $frontendText->sponsor['cta_title'] ?? 'Sponsorship & Partnership' }}</h3>
                    <p>{{ $frontendText->sponsor['cta_desc'] ?? 'Kontak kami untuk informasi lebih lanjut mengenai paket kerjasama dan sponsorship.' }}
                    </p>
                    <a href="mailto:{{ $frontendText->sponsor['cta_email'] ?? 'info@sekolahraheela.sch.id' }}"
                        class="btn btn-secondary">{{ $frontendText->sponsor['cta_btn'] ?? 'Hubungi Kami' }}</a>
                </div>
            </div>
        </div>
    </section>
</div>