<?php

namespace Database\Seeders;

use App\Models\FrontendText;
use Illuminate\Database\Seeder;

class FrontendTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FrontendText::updateOrCreate(
            ['id' => 1],
            [
                'navbar' => [
                    'brand_1' => 'Sekolah',
                    'brand_2' => 'Raheela',
                    'menu_1' => 'Mengapa',
                    'menu_2' => 'Pilar',
                    'menu_3' => 'Program',
                    'menu_4' => 'Sponsor',
                ],
                'hero' => [
                    'date' => 'Sabtu, 27 Juni 2026 | 15.30 — 17.30 WIB',
                    'title' => 'Suara Nurani Bangsa',
                    'subtitle' => 'School Fair 2026',
                    'motto' => 'Mari Membesarkan Generasi Dengan Hati',
                    'btn_text' => 'Dukung Kami',
                ],
                'about' => [
                    'title' => 'Mengapa School Fair?',
                    'items' => [
                        ['icon' => '✨', 'title' => 'Ruang Ekspresi', 'desc' => 'Memberikan kesempatan bagi setiap anak untuk mengekspresikan diri melalui seni, musik, dan drama dengan penuh keberanian.'],
                        ['icon' => '🎭', 'title' => 'Panggung Karakter', 'desc' => 'Wadah nyata pembentukan karakter melalui proses latihan dan kolaborasi yang mendalam.'],
                        ['icon' => '❤️', 'title' => 'Keluarga & Emosi', 'desc' => 'Momen berharga bagi orang tua menyaksikan pertumbuhan anak, menciptakan ikatan emosional yang mendalam.'],
                    ],
                ],
                'pillars' => [
                    'title' => 'Empat Pilar Utama',
                    'items' => [
                        ['number' => '01', 'icon' => '🇮🇩', 'title' => 'Cinta Tanah Air', 'desc' => 'Menumbuhkan rasa bangga dan tanggung jawab terhadap Indonesia. Generasi muda yang mencintai negerinya.'],
                        ['number' => '02', 'icon' => '🌿', 'title' => 'Ekologi', 'desc' => 'Membangun kepekaan dan cinta terhadap alam. Anak-anak belajar menjaga bumi sebagai amanah.'],
                        ['number' => '03', 'icon' => '🤝', 'title' => 'Kemanusiaan', 'desc' => 'Menumbuhkan empati dan kepedulian terhadap sesama manusia dalam bingkai persaudaraan.'],
                        ['number' => '04', 'icon' => '✨', 'title' => 'Spiritualitas', 'desc' => 'Menjaga identitas dan kedalaman batin melalui fondasi spiritual yang kokoh dan bermakna.'],
                    ],
                ],
                'program' => [
                    'title' => 'Program Acara',
                    'items' => [
                        ['number' => '01', 'title' => 'Opening & Comedy', 'desc' => 'Opening MC Anak SD & Stand Up Comedy siswa SD-SMA.'],
                        ['number' => '02', 'title' => 'Penampilan Choir', 'desc' => 'Membawakan lagu-lagu yang menyentuh hati dan jiwa.'],
                        ['number' => '03', 'title' => 'Drama & Monolog', 'desc' => 'Ekspresi suara hati anak-anak Indonesia yang jujur.'],
                        ['number' => '04', 'title' => 'Grand Finale', 'desc' => 'Puisi Reflektif dan penutup megah: Tombo Ati Medley.'],
                    ],
                ],
                'sponsor' => [
                    'title' => 'Mari Menjadi Bagian dari Perubahan',
                    'subtitle' => 'Dukung kami dalam membesarkan generasi dengan hati.',
                    'cta_title' => 'Sponsorship & Partnership',
                    'cta_desc' => 'Kontak kami untuk informasi lebih lanjut mengenai paket kerjasama dan sponsorship.',
                    'cta_btn' => 'Hubungi Kami',
                    'cta_email' => 'info@sekolahraheela.sch.id',
                ],
                'footer' => [
                    'brand' => 'Sekolah Raheela',
                    'copyright' => '© 2026 Sekolah Raheela. All Rights Reserved.',
                ],
                // For subpages
                'portfolio_detail' => [
                    'desc_label' => 'Detail Sejarah',
                    'gallery_label' => 'Galeri School Fair',
                    'work_label' => 'Detail Acara',
                    'related_label' => 'Dokumentasi Lainnya',
                    'wa_button' => '💬 Tanya Informasi Acara',
                ],
                'gallery' => [
                    'label' => 'Galeri School Fair',
                    'subtitle' => 'Kumpulan momen berharga School Fair dari tahun ke tahun.',
                    'empty_text' => 'Belum ada dokumentasi untuk tahun ini.',
                ],
                'other_categories' => [
                    'label' => 'Tahun Lainnya',
                    'title' => 'Lihat dokumentasi School Fair di tahun-tahun sebelumnya.',
                ],
                'game' => [
                    'title' => 'Raheela Adventure 2026',
                    'subtitle' => 'Future Leaders, Hati Qur’ani, Sekolah Rimba',
                    'quiz_markdown' => "---
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
- [ ] Hanya dibaca saat ujian",
                ],
            ]
        );
    }
}
