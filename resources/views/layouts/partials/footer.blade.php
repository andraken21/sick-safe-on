<footer class="site-footer">
    <div class="footer-main">
        <div class="footer-container">

            {{-- BRAND --}}
            <div class="footer-col brand-col">
                <div class="logo-wrapper">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Sick Safe ON" width="45">
                    <h2 class="footer-logo">Sick Safe <span class="logo-on">ON</span></h2>
                </div>
                <p class="brand-description">
                    Platform digital untuk manajemen farmasi rumah sakit yang terintegrasi, aman, dan mudah digunakan.
                </p>
                <div class="security-badge">
                    <i class="fas fa-lock"></i> Keamanan Data Terjamin
                </div>
            </div>

            {{-- KONTAK --}}
            <div class="footer-col">
                <h4>Kontak</h4>
                <ul class="contact-list">
                    <li><i class="fas fa-phone-alt"></i> +62 812-3456-7890</li>
                    <li><i class="fas fa-envelope"></i> info@sicksafeon.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> Jl. Alumni No.3, Padang Bulan</li>
                </ul>
            </div>

            {{-- LAYANAN --}}
            <div class="footer-col">
                <h4>Layanan Kami</h4>
                <ul>
                    <li><a href="#">Resep Digital</a></li>
                    <li><a href="#">Validasi Apoteker</a></li>
                    <li><a href="#">Pembayaran Aman</a></li>
                    <li><a href="#">Distribusi Obat</a></li>
                </ul>
            </div>

            {{-- PERUSAHAAN --}}
            <div class="footer-col">
                <h4>Perusahaan</h4>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Tim</a></li>
                    <li><a href="#">Karier</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>

            {{-- DUKUNGAN --}}
            <div class="footer-col">
                <h4>Dukungan</h4>
                <ul>
                    <li><a href="#">Dokumentasi</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Hubungi Kami</a></li>
                </ul>
            </div>

        </div>
    </div>

    <div class="footer-divider"></div>

    <div class="footer-bottom">
        <div class="bottom-container">
            <p>© {{ date('Y') }} Sick Safe ON. All rights reserved.</p>
            <div class="bottom-links">
                <a href="#">Privacy &amp; Policy</a>
                <a href="#">Terms &amp; Condition</a>
            </div>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        background-color: #0A2E3F;
        color: #E1F1FE;
        width: 100%;
        border-top: 1px solid rgba(255,255,255,0.06);
    }

    .footer-main { padding: 36px 28px 26px; }

    .footer-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 28px 45px;
        align-items: flex-start;
    }

    .brand-col { flex: 0 0 260px; min-width: 200px; }

    .logo-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .footer-logo { font-size: 1rem; font-weight: 700; color: #fff; }
    .footer-logo .logo-on { color: #2ecc71; }

    .brand-description {
        font-size: 0.8rem;
        line-height: 1.7;
        margin-bottom: 12px;
        color: #B0C4DE;
    }

    .security-badge {
        font-size: 0.8rem;
        background: rgba(46,204,113,0.10);
        border: 1px solid rgba(46,204,113,0.2);
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 11px;
        border-radius: 30px;
        color: #a8e6c3;
    }

    .security-badge i { color: #2ecc71; }

    .footer-col { min-width: 110px; }

    .footer-col h4 {
        font-size: 0.68rem;
        font-weight: 600;
        margin-bottom: 14px;
        color: #fff;
        letter-spacing: 0.6px;
        text-transform: uppercase;
    }

    .footer-col ul { list-style: none; padding-left: 0; margin: 0; }
    .footer-col ul li { margin-bottom: 8px; }

    .footer-col ul li a {
        color: #8DA6B5;
        text-decoration: none;
        font-size: 0.78rem;
        transition: all 0.2s;
        display: inline-block;
    }

    .footer-col ul li a:hover { color: #2ecc71; transform: translateX(3px); }

    .contact-list { list-style: none; padding-left: 0; margin: 0; }

    .contact-list li {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 9px;
        font-size: 0.78rem;
        color: #8DA6B5;
        line-height: 1.5;
    }

    .contact-list li i {
        width: 15px;
        color: #2ecc71;
        font-size: 0.78rem;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .footer-divider {
        height: 1px;
        background: rgba(255,255,255,0.07);
        margin: 0 28px;
    }

    .footer-bottom { padding: 14px 28px; }

    .bottom-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .bottom-container p { font-size: 0.71rem; color: #5a7a8a; }

    .bottom-links { display: flex; gap: 16px; }

    .bottom-links a {
        color: #5a7a8a;
        text-decoration: none;
        font-size: 0.71rem;
        transition: color 0.2s;
    }

    .bottom-links a:hover { color: #2ecc71; }

    @media (max-width: 768px) {
        .footer-container { flex-direction: column; gap: 22px; }
        .brand-col, .footer-col { min-width: 100%; }
        .bottom-container { flex-direction: column; text-align: center; align-items: center; }
    }
</style>