<?php

namespace App\Filament\Resources\FrontendTexts\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class FrontendTextForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Sekolah Raheela Texts')
                    ->tabs([
                        Tabs\Tab::make('Navigasi & Hero')
                            ->schema([
                                TextInput::make('navbar.brand_1')->label('Nama Brand (Atas)')->default('Sekolah'),
                                TextInput::make('navbar.brand_2')->label('Nama Brand (Bawah)')->default('Raheela'),
                                TextInput::make('hero.date')->label('Tanggal Acara')->default('Sabtu, 27 Juni 2026 | 15.30 — 17.30 WIB'),
                                TextInput::make('hero.title')->label('Judul Hero')->default('Suara Nurani Bangsa'),
                                TextInput::make('hero.subtitle')->label('Sub-judul Hero')->default('School Fair 2026'),
                                TextInput::make('hero.motto')->label('Motto')->default('Mari Membesarkan Generasi Dengan Hati'),
                                TextInput::make('hero.btn_text')->label('Teks Tombol Hero')->default('Dukung Kami'),
                            ]),
                        Tabs\Tab::make('Mengapa (About)')
                            ->schema([
                                TextInput::make('about.title')->label('Judul Seksi')->default('Mengapa School Fair?'),
                                Repeater::make('about.items')
                                    ->label('Poin Alasan')
                                    ->schema([
                                        TextInput::make('icon')->label('Icon (Emoji)'),
                                        TextInput::make('title')->label('Judul'),
                                        Textarea::make('desc')->label('Deskripsi'),
                                    ])->columns(1),
                            ]),
                        Tabs\Tab::make('Empat Pilar')
                            ->schema([
                                TextInput::make('pillars.title')->label('Judul Seksi')->default('Empat Pilar Utama'),
                                Repeater::make('pillars.items')
                                    ->label('Daftar Pilar')
                                    ->schema([
                                        TextInput::make('number')->label('Nomor (01, 02, etc)'),
                                        TextInput::make('icon')->label('Icon (Emoji)'),
                                        TextInput::make('title')->label('Judul Pilar'),
                                        Textarea::make('desc')->label('Deskripsi Pilar'),
                                    ])->columns(1),
                            ]),
                        Tabs\Tab::make('Program Acara')
                            ->schema([
                                TextInput::make('program.title')->label('Judul Seksi')->default('Program Acara'),
                                Repeater::make('program.items')
                                    ->label('Daftar Program')
                                    ->schema([
                                        TextInput::make('number')->label('Nomor/Urutan'),
                                        TextInput::make('title')->label('Nama Program'),
                                        Textarea::make('desc')->label('Deskripsi Program'),
                                    ])->columns(1),
                            ]),
                        Tabs\Tab::make('Sponsor & Partnership')
                            ->schema([
                                TextInput::make('sponsor.title')->label('Judul Seksi'),
                                TextInput::make('sponsor.subtitle')->label('Sub-judul Seksi'),
                                TextInput::make('sponsor.cta_title')->label('Judul Kotak CTA'),
                                Textarea::make('sponsor.cta_desc')->label('Deskripsi Kotak CTA'),
                                TextInput::make('sponsor.cta_btn')->label('Teks Tombol'),
                                TextInput::make('sponsor.cta_email')->label('Email Kontak'),
                            ]),
                        Tabs\Tab::make('Halaman Dokumentasi (Portfolio)')
                            ->schema([
                                TextInput::make('portfolio_detail.desc_label')->label('Label Deskripsi')->default('Detail Sejarah'),
                                TextInput::make('portfolio_detail.gallery_label')->label('Label Galeri')->default('Galeri School Fair'),
                                TextInput::make('portfolio_detail.work_label')->label('Label Detail Acara')->default('Detail Acara'),
                                TextInput::make('portfolio_detail.related_label')->label('Label Dokumentasi Lain')->default('Dokumentasi Lainnya'),
                                TextInput::make('portfolio_detail.wa_button')->label('Teks Tombol WA')->default('💬 Tanya Informasi Acara'),
                            ]),
                        Tabs\Tab::make('Halaman Galeri Tahun')
                            ->schema([
                                TextInput::make('gallery.label')->label('Judul Galeri')->default('Galeri School Fair'),
                                Textarea::make('gallery.subtitle')->label('Sub-judul Galeri'),
                                TextInput::make('gallery.empty_text')->label('Pesan Jika Kosong'),
                                TextInput::make('other_categories.label')->label('Label Tahun Lain'),
                                TextInput::make('other_categories.title')->label('Judul Tahun Lain'),
                            ]),
                        Tabs\Tab::make('Footer')
                            ->schema([
                                TextInput::make('footer.brand')->label('Nama Brand Footer'),
                                TextInput::make('footer.copyright')->label('Teks Hak Cipta'),
                            ]),
                        Tabs\Tab::make('Game Edukatif')
                            ->schema([
                                TextInput::make('game.title')->label('Judul Game')->default('Raheela Adventure 2026'),
                                TextInput::make('game.subtitle')->label('Sub-judul Game')->default('Future Leaders, Hati Qur’ani, Sekolah Rimba'),
                                \Filament\Forms\Components\TagsInput::make('game.wordsearch_words')
                                    ->label('Kata Tersembunyi (Word Search)')
                                    ->helperText('Ketik kata lalu tekan Enter. Minimal 5, maksimal 10 kata.')
                                    ->default(['ISLAM', 'IMAN', 'IHSAN', 'PUASA', 'ZAKAT', 'SHOLAT', 'RAHEELA', 'NURANI', 'AKHLAK', 'ADAB']),
                                \Filament\Forms\Components\FileUpload::make('game.match_images')
                                    ->label('Gambar Cocokkan Kartu (Memory Match)')
                                    ->helperText('Upload tepat 8 gambar untuk dijadikan pasangan kartu.')
                                    ->multiple()
                                    ->image()
                                    ->directory('game_images'),
                                Textarea::make('game.quiz_markdown')
                                    ->label('Konten Kuis (Markdown)')
                                    ->rows(15)
                                    ->helperText('Gunakan format # Pertanyaan diikuti pilihan - [x] Benar atau - [ ] Salah.')
                                    ->default(<<<'MD'
---
title: Pemimpin Masa Depan
---
# Apa pilar pertama Sekolah Raheela?
- [x] Cinta Tanah Air
- [ ] Tidur Siang
- [ ] Makan Coklat

# Bagaimana sikap kita terhadap alam?
- [ ] Merusak
- [x] Menjaga & Melestarikan
- [ ] Acuh tak acuh

# Apa yang dimaksud dengan Hati Qur'ani?
- [x] Menjadikan Al-Quran sebagai pedoman hidup
- [ ] Hafal Al-Quran tapi tidak diamalkan
- [ ] Hanya dibaca saat ujian
MD),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
