<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer - Sick Safe ON</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-left">
                <div class="logo-wrapper">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo" width="80">
                    <h3 class="footer-logo">Sick Safe <span class="logo-on">ON</span></h3>
                </div>
                <p class="footer-desc">
                    Platform terintegrasi untuk<br>
                    pengelolaan resep, obat, dan <br>
                    pasien secara aman & efisien.
                </p>
                <div class="security-text">
                    <span class="check">✓</span> Keamanan Data Terjamin
                </div>
                <div class="social-media-container">
                    <a href="#" class="social-media" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-media" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-media" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-media" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
            <div class="link-container">
                <div class="footer-menu">
                    <h4>Layanan Kami</h4>
                    <ul>
                        <li><a href="#" class="menu-link">Resep Digital</a><span class="menu-desc">Kelola resep dengan mudah & aman</span></li>
                        <li><a href="#" class="menu-link">Validasi Apoteker</a><span class="menu-desc">Obat sesuai & aman</span></li>
                        <li><a href="#" class="menu-link">Pembayaran Aman</a><span class="menu-desc">Mandiri atau BPJS</span></li>
                        <li><a href="#" class="menu-link">Distribusi Obat</a><span class="menu-desc">Antar langsung ke rumah</span></li>
                    </ul>
                </div>
                 <div class="footer-menu">
                    <h4>Perusahaan</h4>
                    <ul>
                       <li><a href="#" class="menu-link-simple">Tentang Kami</a></li>
                       <li><a href="#" class="menu-link-simple">Tim</a></li>
                       <li><a href="#" class="menu-link-simple">Karier</a></li>
                       <li><a href="#" class="menu-link-simple">Blog</a></li>
                    </ul>
                   <h4>Dukungan</h4>
                   <ul>
                      <li><a href="#" class="menu-link-simple">Dokumentasi</a></li>
                      <li><a href="#" class="menu-link-simple">FAQ</a></li>
                      <li><a href="#" class="menu-link-simple">Kebijakan Privasi</a></li>
                   </ul>
                </div>
                <div class="footer-menu">
                    <h4>Hubungi Kami</h4>
                    <ul class="contact-list">
                        <li><i class="fas fa-envelope"></i> <a href="mailto:info@sicksafeon.com" class="contact-link">info@sicksafeon.com</a></li>
                        <li><i class="fas fa-phone-alt"></i> <a href="tel:+6281234567890" class="contact-link">+62 812-3456-7890</a></li>
                        <li><i class="fas fa-map-marker-alt"></i> Jl. Alumni No.3, Padang Bulan</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2026 Sick Safe ON. All rights reserved.</p>
        </div>
    </footer>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #0A2E3F;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .site-footer {
            background-color: #0A2E3F;
            color: #D9E6F2;
            font-family: 'Inter', 'Poppins', sans-serif;
            width: 100%;
            margin: 0;
            padding: 0;
        }

       
        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 40px 60px;
            padding: 60px 40px 50px 40px;
        }

        .footer-left {
            flex: 1;
            min-width: 280px;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .footer-logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .logo-on {
            color: #2BAE66;
        }

        .footer-desc {
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 20px;
            color: #C2D6E6;
        }

        .security-text {
            font-size: 0.85rem;
            background: rgba(43, 174, 102, 0.12);
            display: inline-block;
            padding: 6px 14px;
            border-radius: 40px;
            font-weight: 500;
            margin-bottom: 24px;
        }

        .security-text .check {
            color: #2BAE66;
            margin-right: 6px;
            font-weight: bold;
        }
        
        .social-media-container {
            display: flex;
            gap: 12px;
            margin-top: 8px;
        }

        .social-media {
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #D9E6F2;
            font-size: 1.2rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .social-media:hover {
            background: #2BAE66;
            color: #0A2E3F;
            transform: translateY(-3px);
        }

        .link-container {
            flex: 2;
            display: flex;
            flex-wrap: wrap;
            gap: 40px 60px;
        }

        .footer-menu {
            min-width: 160px;
        }

        .footer-menu h4 {
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
            color: #FFFFFF;
            opacity: 0.8;
            position: relative;
            display: inline-block;
        }

        .footer-menu h4:after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 35px;
            height: 2px;
            background-color: #2BAE66;
        }

        .footer-menu ul {
            list-style: none;
        }

        .footer-menu ul li {
            margin-bottom: 16px;
        }
        .menu-link {
            color: #E6F0F5;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            display: block;
            transition: all 0.2s ease;
        }

        .menu-link:hover {
            color: #2BAE66;
            transform: translateX(4px);
        }

        .menu-desc {
            font-size: 0.75rem;
            color: #8DA6B5;
            display: block;
            margin-top: 4px;
        }

        .menu-link-simple {
            color: #C2D6E6;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: inline-block;
        }

        .menu-link-simple:hover {
            color: #2BAE66;
            transform: translateX(4px);
        }
        .contact-list {
            list-style: none;
        }

        .contact-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            font-size: 0.9rem;
            color: #C2D6E6;
        }

        .contact-list li i {
            width: 22px;
            color: #2BAE66;
            font-size: 1rem;
        }

        .contact-link {
            color: #C2D6E6;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .contact-link:hover {
            color: #2BAE66;
        }

        .mt-2 {
            margin-top: 28px;
        }
        .footer-bottom {
            background-color: #0A2E3F;
            text-align: center;
            padding: 20px 20px 32px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 0.8rem;
            color: #8DA6B5;
        }

        .footer-bottom p {
            margin: 0;
        }
        .footer-menu:first-child h4 {
        margin-top: 25px;
        }

        .footer-menu:not(:first-child) h4 {
        margin-top: 25px;
        }
        @media (max-width: 1024px) {
            .footer-container {
                gap: 40px;
                padding: 50px 30px;
            }
            .link-container {
                gap: 40px;
            }
        }

        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                gap: 40px;
                padding: 40px 25px;
            }
            .footer-left {
                min-width: 100%;
            }
            .link-container {
                flex-direction: column;
                gap: 35px;
            }
            .footer-menu {
                min-width: 100%;
            }
        }
    </style>
</body>
</html>

