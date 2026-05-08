<footer class="site-footer wave-top">
    <div class="footer-container">
        <!-- KOLOM 1: Logo + Teks + Deskripsi + Keamanan -->
        <div class="footer-col">
            <div class="logo-wrapper">
                <img src="{{ asset('image/logo.png') }}" alt="Logo Saya" width="100">
                <h3 class="footer-logo">Sick Safe <span class="logo-on">ON</span></h3>
            </div>
            <p class="footer-desc">
                Platform terintegrasi untuk<br>
                pengelolaan resep, obat, dan<br>
                pasien secara aman dan efisien.
            </p>
            <div class="security-plain">
            <span class="security-title"> Keamanan Data Terjamin</span><br>
              Kami menjaga data Anda dengan<br>
              standar keamanan terbaik.
</div>
        </div>
        <div class="footer-col">
            <h4>Layanan Kami</h4>
            <div class="service-list">
                <div class="service-item">
                    <div class="service-title">Resep Digital</div>
                    <div class="service-desc">Kelola resep dengan mudah dan aman.</div>
                </div>
                <div class="service-item">
                    <div class="service-title">Validasi Apoteker</div>
                    <div class="service-desc">Memastikan obat sesuai dan aman.</div>
                </div>
                <div class="service-item">
                    <div class="service-title">Pembayaran Aman</div>
                    <div class="service-desc">Transaksi mandiri atau melalui BPJS.</div>
                </div>
                <div class="service-item">
                    <div class="service-title">Distribusi Obat</div>
                    <div class="service-desc">Pengantaran obat langsung ke rumah.</div>
                </div>
            </div>
        </div>
        <div class="footer-col">
            <h4>Hubungi Kami</h4>
            <ul class="footer-contact">
                <li>📧 info@sicksafeon.com</li>
                <li>📞 +62 812-3456-7890</li>
                <li>📍 Jl. Alumni No.3, Padang Bulan</li>
            </ul>
            <h4 class="follow-heading">Ikuti Kami</h4>
            <div class="social-plain">
                <a href="#"><i class="fab fa-facebook-f"></i> Facebook</a>
                <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© <span class="copyright-year">2026</span> Sick Safe ON. All rights reserved.</p>
    </div>
</footer>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="{{asset('css/footer.css')}}">
<style>
    
    .service-item {
        margin-bottom: 20px;
    }
    .security-title {
    color: #2ecc71;
    font-weight: 500; 
}
    .service-desc {
        font-size: 0.8rem;
        color: #E1F1FE;
        line-height: 1.4;
        display: block;
    }
    .site-footer {
        background-color: #004369;
        color: #E1F1FE;
        padding: 0 20px 20px;
        font-family: 'Poppins', 'Inter', 'Arial', sans-serif;
        width: 100%;
        margin-top: 60px;
        position: relative;
    }
    .footer-container {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 30px 40px;
        padding: 20px 0 30px;
    }
    .footer-col {
        flex: 1;
        min-width: 180px;
        position: relative;
    }
    .logo-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 16px;
    }
    .footer-logo {
        font-size: 1.5rem;
        font-weight: 700;
        color: #E1F1FE;
        margin-bottom: 0;   
    }
    .logo-on {
        color: #2ecc71;
    }

    .footer-desc {
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 16px;
        color: #E1F1FE;
    }
    .security-plain {
        font-size: 0.85rem;
        color: #E1F1FE;
        line-height: 1.5;
        margin-top: 10px;
    }
    .footer-col h4 {
        font-size: 1.1rem;
        margin-bottom: 18px;
        color: #E1F1FE;
        position: relative;
        display: inline-block;
    }
    .footer-col h4:after {
        content: '';
        position: absolute;
        bottom: -6px;
        left: 0;
        width: 40px;
        height: 2px;
        background-color: #4db8ff;
    }
    .footer-contact {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .footer-contact li {
        margin-bottom: 12px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .social-plain {
        display: flex;
        gap: 20px;
        margin-top: 5px;
    }
    .social-plain a {
        color: #E1F1FE;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.9rem;
    }
    .social-plain a:hover {
        color: #2ecc71;
    }
    .footer-bottom {
        background-color: #3FBBA0;
        text-align: center;
        margin-top: 20px;
        padding: 15px 20px;
        border-radius: 16px 16px 0 0;
        font-size: 0.8rem;
        color: #E1F1FE;
    }
    .footer-bottom .copyright-year {
        font-weight: 900;
        font-size: 1rem;
        
    }
    .follow-heading {
        position: relative;
        margin-top: 12px;
        padding-top: 12px;
        display: inline-block;
    }
    .follow-heading::before {
        content: '';
        position: absolute;
        top: 0;
        left: 3;
        width: 350%;           
        height: 1px;
        background-color: rgba(255, 255, 255, 0.2);
    }

    .security-plain {
        position: relative;
        padding-top: 12px;
        margin-top: 12px;
    }
   .security-plain::before {
        content: '';
        position: absolute;
        top: 0;
        left: 5;
        width: 70%;
        height: 1px;
        background-color: rgba(255, 255, 255, 0.2);
    }
    .footer-col:not(:last-child)::after {
        content: '';
        position: absolute;
        right: -5px;   
        top: 0;
        height: 100%;
        width: 1px;
        background-color: rgba(255, 255, 255, 0.2);
    }
    @media (max-width: 768px) {
        .footer-col:not(:last-child)::after {
            display: none;
        }
        .footer-container {
            gap: 30px;
        }
    }
</style>