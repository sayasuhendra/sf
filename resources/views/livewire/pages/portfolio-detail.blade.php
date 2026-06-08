<?php 
use Livewire\Volt\Component;
use App\Models\SiteSetting;
use App\Models\Project;

new class extends Component {
    public $project;
    public $relatedProjects;
    public $settings;
    public $ft;

    public function mount($id) {
        try {
            $this->project = Project::findOrFail($id);
            $this->relatedProjects = Project::where('id', '!=', $id)->latest()->take(3)->get();
            $this->settings = SiteSetting::first() ?? new SiteSetting(['whatsapp_number' => '6281212345678']);
            $this->ft = \App\Models\FrontendText::first();
        } catch (\Exception $e) {
            abort(404);
        }
    }
};
?>

<div>
    @section('title', $project->title . ' — Documentation History Sekolah Raheela')

    <style>
        .project-hero {
            position: relative;
            min-height: 40vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 120px 24px 60px;
            overflow: hidden;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset((is_array($project->photos) && isset($project->photos[0])) ? (str_starts_with($project->photos[0], 'img/') ? $project->photos[0] : 'storage/' . $project->photos[0]) : "") }}') center/cover no-repeat;
            color: white;
            text-align: center;
        }

        .project-hero-content {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
        }

        .project-breadcrumb {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .project-title {
            font-size: clamp(32px, 7vw, 48px);
            font-weight: 800;
            letter-spacing: -.02em;
            line-height: 1.2;
            margin-bottom: 24px;
            font-family: var(--font-serif);
        }

        .project-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            justify-content: center;
        }

        .project-badge {
            background: var(--primary-color);
            border-radius: 100px;
            padding: 4px 14px;
            font-size: 11px;
            font-weight: 700;
            color: var(--white);
            text-transform: uppercase;
        }

        .page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .project-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 48px;
            padding: 60px 0 100px;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .photo-item {
            border-radius: 20px;
            overflow: hidden;
            aspect-ratio: 4/3;
            background: #f0f0f0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        
        .photo-item:hover {
            transform: scale(1.02);
        }

        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar-card {
            background: var(--white);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 24px;
            padding: 30px;
            margin-bottom: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        }
        
        .sidebar-card h4 {
            color: var(--secondary-color);
            font-family: var(--font-serif);
            margin-bottom: 20px;
            font-size: 1.2rem;
        }

        @media (max-width: 900px) {
            .project-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="project-hero">
        <div class="project-hero-content">
            <nav class="project-breadcrumb">
                <a href="{{ route('home') }}" style="color: rgba(255,255,255,0.7); text-decoration: none;">BERANDA</a>
                <span>/</span>
                <span>DOKUMENTASI</span>
            </nav>
            <h1 class="project-title">{{ $project->title }}</h1>
            <div class="project-meta-row">
                <span class="project-badge">{{ is_array($project->category) ? implode(', ', $project->category) : $project->category }}</span>
                <span style="color: rgba(255,255,255,0.8); font-size: 14px;">📅 {{ $project->year }}</span>
            </div>
        </div>
    </div>

    <div class="page-container">
        <div class="project-layout">
            <div class="project-main">
                <section class="description-section" style="margin-bottom: 60px;">
                    <h3 style="color: var(--primary-color); font-family: var(--font-serif); font-size: 1.5rem; margin-bottom: 20px;">
                        {{ $ft->portfolio_detail['desc_label'] ?? 'Detail Sejarah' }}</h3>
                    <div style="font-size: 1.1rem; color: var(--text-muted); line-height: 1.8;">
                        @foreach($project->description ?? [] as $p)
                            <p style="margin-bottom: 16px;">{{ is_array($p) ? ($p['line'] ?? '') : $p }}</p>
                        @endforeach
                    </div>
                </section>

                <section class="gallery-section">
                    <h3 style="color: var(--primary-color); font-family: var(--font-serif); font-size: 1.5rem; margin-bottom: 30px;">
                        {{ $ft->portfolio_detail['gallery_label'] ?? 'Galeri Foto' }}</h3>
                    <div class="photo-grid">
                        @foreach($project->photos as $photo)
                            @php
                                $photoUrl = str_starts_with($photo, 'img/') ? asset($photo) : asset('storage/' . $photo);
                            @endphp
                            <a href="{{ $photoUrl }}" class="glightbox photo-item">
                                <img src="{{ $photoUrl }}" alt="{{ $project->title }}" loading="lazy">
                            </a>
                        @endforeach
                    </div>
                </section>
            </div>

            <aside class="sidebar">
                <div class="sidebar-card">
                    <h4>{{ $ft->portfolio_detail['work_label'] ?? 'Detail Acara' }}</h4>
                    <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                        <span style="color: var(--text-muted); font-size: 14px;">Tahun</span>
                        <span style="font-weight: 700; font-size: 14px;">{{ $project->year }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                        <span style="color: var(--text-muted); font-size: 14px;">Lokasi</span>
                        <span style="font-weight: 700; font-size: 14px;">{{ $project->location }}</span>
                    </div>

                    <a href="mailto:info@sekolahraheela.sch.id" 
                        class="btn btn-primary"
                        style="margin-top: 30px; width: 100%; display: flex; justify-content: center; text-decoration: none;">
                        {{ $ft->portfolio_detail['wa_button'] ?? 'Hubungi Kami' }}
                    </a>
                </div>

                <div class="sidebar-card">
                    <h4>{{ $ft->portfolio_detail['related_label'] ?? 'Dokumentasi Lainnya' }}</h4>
                    @foreach($relatedProjects as $rel)
                        <a href="{{ route('portfolio.detail', $rel->id) }}"
                            style="display: flex; gap: 15px; align-items: center; text-decoration: none; margin-bottom: 20px;">
                            <div style="width: 60px; height: 60px; border-radius: 12px; overflow: hidden; flex-shrink: 0; background: #f0f0f0;">
                                @php
                                    $firstPhoto = $rel->photos[0] ?? "";
                                    $relPhotoUrl = str_starts_with($firstPhoto, 'img/') ? asset($firstPhoto) : asset('storage/' . $firstPhoto);
                                @endphp
                                <img src="{{ $relPhotoUrl }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div>
                                <div style="color: var(--text-color); font-weight: 700; font-size: 14px;">{{ $rel->title }}</div>
                                <div style="color: var(--text-muted); font-size: 12px;">{{ $rel->year }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', () => {
                if (typeof GLightbox !== 'undefined') {
                    const lightbox = GLightbox({ selector: '.glightbox' });
                }
            });
        </script>
    @endpush
</div>