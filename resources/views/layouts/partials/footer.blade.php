@php
    $ft = \App\Models\FrontendText::first();
@endphp
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo">{{ $ft->footer['brand'] ?? 'Sekolah Raheela' }}</div>
            <p>School Fair 2026 "Suara Nurani Bangsa"</p>
            <div class="footer-contact">
                <span>Email: info@sekolahraheela.sch.id</span>
            </div>
        </div>
        <div class="footer-bottom">
            <p>{{ $ft->footer['copyright'] ?? '© 2026 Sekolah Raheela. All Rights Reserved.' }}</p>
        </div>
    </div>
</footer>