<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sick Safe ON – Innovating for Healthier Tomorrows</title>
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
</head>
<body>

{{-- ══ NAVBAR ══ --}}
<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('image/logo.png') }}" alt="Logo Aplikasi" width="100px" >
        <span class="logo-text">Sick Safe <span>ON</span></span>
    </div>
    <ul class="nav-links">
        <li><a href="#beranda">Beranda</a></li>
        <li><a href="#tentang">Tentang</a></li>
        <li><a href="#fitur">Fitur</a></li>
        <li><a href="#kontak">Kontak</a></li>
    </ul>
    <div class="nav-actions">
        <a href="/login" class="btn-ghost">Masuk</a>
        <a href="/register" class="btn-primary">Daftar</a>
    </div>
    <button class="hamburger" aria-label="Menu">
        <span></span><span></span><span></span>
    </button>
</nav>

{{-- ══ HERO ══ --}}
<section class="hero" id="beranda">
    <div class="hero-content">
        <div class="hero-badge">
            <span class="dot"></span>
            Platform Manajemen Farmasi #1 di Indonesia
        </div>

        <h1 class="hero-title">
            Kelola Resep, Obat,<br>
            dan Pasien dalam<br>
            <span class="accent">Satu Sistem Terintegrasi</span>
        </h1>

        <p class="hero-desc">
            Sick Safe ON membantu rumah sakit mengelola resep, stok obat, pembayaran,
            hingga distribusi obat dengan lebih mudah, cepat, dan aman.
        </p>

        <div class="hero-cta">
            <a href="/register" class="btn-primary btn-lg">Mulai Sekarang</a>
            <a href="#fitur" class="btn-outline-lg">Pelajari Lebih Lanjut</a>
        </div>
    </div>

    {{-- Mock Dashboard Card --}}
    <div class="hero-visual">
        <div class="float-card top-left">
            <span class="float-icon">✅</span>
            <div class="float-text">
                <strong>Resep Tervalidasi</strong>
                <span>RSP-2024-0051 · barusan</span>
            </div>
        </div>

        <div class="hero-card-wrap">
            <div class="card-header-bar">
                <span class="dot-red"></span>
                <span class="dot-yellow"></span>
                <span class="dot-green"></span>
                <span class="card-title-bar">🛡️ Sick Safe ON — Dashboard Pasien</span>
            </div>

            <div class="stats-row">
                <div class="stat-box highlight">
                    <div class="num">2</div>
                    <div class="lbl">Resep Aktif</div>
                </div>
                <div class="stat-box">
                    <div class="num">1</div>
                    <div class="lbl">Menunggu Bayar</div>
                </div>
                <div class="stat-box">
                    <div class="num">0</div>
                    <div class="lbl">Siap Diambil</div>
                </div>
            </div>

            <div style="font-size:.78rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:.75rem;">Resep Terbaru</div>

            <div class="resep-list">
                <div class="resep-item">
                    <div class="ri-left">
                        <div class="resep-icon">📋</div>
                        <div class="resep-info">
                            <div class="rnum">Resep #RSP-2024-0051</div>
                            <div class="rdoc">Dr. Budi Santoso · 20 Mei 2024</div>
                        </div>
                    </div>
                    <span class="badge badge-warning">Diproses</span>
                </div>
                <div class="resep-item">
                    <div class="ri-left">
                        <div class="resep-icon">📋</div>
                        <div class="resep-info">
                            <div class="rnum">Resep #RSP-2024-0048</div>
                            <div class="rdoc">Dr. Budi Santoso · 15 Mei 2024</div>
                        </div>
                    </div>
                    <span class="badge badge-success">Selesai</span>
                </div>
            </div>
        </div>

        <div class="float-card bottom-right">
            <span class="float-icon">💊</span>
            <div class="float-text">
                <strong>Stok Aman</strong>
                <span>Paracetamol 500mg</span>
            </div>
        </div>
    </div>
</section>

{{-- ══ FEATURE CARDS ══ --}}
<div class="features-strip" id="fitur">
    <div class="feature-card">
        <div class="feature-icon-wrap">📝</div>
        <div class="feature-title">Resep Digital</div>
        <div class="feature-desc">Buat, kirim, dan kelola resep secara digital. Aman dan mudah diakses kapan saja.</div>
    </div>
    <div class="feature-card">
        <div class="feature-icon-wrap">✅</div>
        <div class="feature-title">Validasi Apoteker</div>
        <div class="feature-desc">Apoteker memvalidasi resep secara real-time untuk memastikan obat tepat dan aman.</div>
    </div>
    <div class="feature-card">
        <div class="feature-icon-wrap">💳</div>
        <div class="feature-title">Pembayaran Aman</div>
        <div class="feature-desc">Bayar mandiri atau via BPJS Kesehatan dengan proses yang mudah dan transparan.</div>
    </div>
    <div class="feature-card">
        <div class="feature-icon-wrap">🚚</div>
        <div class="feature-title">Distribusi Obat</div>
        <div class="feature-desc">Ambil langsung di apotek atau pilih layanan antar ke rumah dengan mudah.</div>
    </div>
</div>

{{-- ══ HOW IT WORKS ══ --}}
<section class="section" id="tentang">
    <div class="section-label">Cara Kerja</div>
    <h2 class="section-title">Proses Sederhana, Hasil Maksimal</h2>
    <p class="section-sub">Empat langkah mudah untuk mengelola layanan farmasi rumah sakit secara digital dan terintegrasi.</p>

    <div class="steps-grid">
        <div class="step">
            <div class="step-num">1</div>
            <div class="step-title">Dokter Buat Resep</div>
            <div class="step-desc">Dokter membuat resep digital langsung dari dashboard setelah konsultasi dengan pasien.</div>
        </div>
        <div class="step">
            <div class="step-num">2</div>
            <div class="step-title">Apoteker Validasi</div>
            <div class="step-desc">Apoteker menerima, mengecek, dan memvalidasi resep sesuai stok obat yang tersedia.</div>
        </div>
        <div class="step">
            <div class="step-num">3</div>
            <div class="step-title">Pasien Bayar</div>
            <div class="step-desc">Pasien melakukan pembayaran melalui platform, baik mandiri maupun via BPJS Kesehatan.</div>
        </div>
        <div class="step">
            <div class="step-num">4</div>
            <div class="step-title">Obat Diterima</div>
            <div class="step-desc">Pasien mengambil obat di apotek atau memilih layanan antar langsung ke rumah.</div>
        </div>
    </div>
</section>

{{-- ══ ROLES ══ --}}
<section class="section roles-section">
    <div class="section-label">Pengguna Platform</div>
    <h2 class="section-title">Dirancang untuk Semua Peran</h2>
    <p class="section-sub">Setiap pengguna mendapatkan antarmuka yang disesuaikan dengan kebutuhan dan tanggung jawabnya.</p>

    <div class="roles-grid">
        <div class="role-card rc-pasien">
            <div class="role-emoji">🧑‍🤝‍🧑</div>
            <div class="role-title">Pasien</div>
            <div class="role-desc">Lihat resep aktif, pantau status pesanan obat, dan kelola riwayat transaksi pembayaran dengan mudah.</div>
        </div>
        <div class="role-card rc-dokter">
            <div class="role-emoji">👨‍⚕️</div>
            <div class="role-title">Dokter</div>
            <div class="role-desc">Buat resep digital, kelola antrian pasien, dan kirim resep langsung ke apoteker secara real-time.</div>
        </div>
        <div class="role-card rc-apotek">
            <div class="role-emoji">💊</div>
            <div class="role-title">Apoteker</div>
            <div class="role-desc">Validasi resep masuk, kelola stok obat, dan proses pesanan distribusi dengan efisien.</div>
        </div>
        <div class="role-card rc-admin">
            <div class="role-emoji">🛠️</div>
            <div class="role-title">Admin</div>
            <div class="role-desc">Pantau seluruh aktivitas sistem, kelola pengguna, obat, transaksi, dan laporan secara terpusat.</div>
        </div>
    </div>
</section>

{{-- ══ STATS BAND ══ --}}
<div class="stats-band">
    <div class="stat-item">
        <div class="big">120<span>+</span></div>
        <div class="lbl">Pasien Terdaftar</div>
    </div>
    <div class="stat-item">
        <div class="big">25<span>+</span></div>
        <div class="lbl">Dokter Aktif</div>
    </div>
    <div class="stat-item">
        <div class="big">18<span>+</span></div>
        <div class="lbl">Apoteker</div>
    </div>
    <div class="stat-item">
        <div class="big">320<span>+</span></div>
        <div class="lbl">Resep Diproses Bulan Ini</div>
    </div>
</div>

{{-- ══ CTA ══ --}}
<section class="cta-section" id="kontak">
    <div class="section-label" style="text-align:center">Bergabung Sekarang</div>
    <h2 class="section-title" style="text-align:center">Siap Transformasi Digital<br>Farmasi Rumah Sakit Anda?</h2>
    <p class="section-sub" style="text-align:center">
        Daftar gratis hari ini dan rasakan kemudahan pengelolaan resep, obat, dan pasien dalam satu platform terintegrasi.
    </p>
    <a href="/register" class="btn-primary btn-lg">Daftar Gratis Sekarang →</a>
</section>

{{-- ══ FOOTER ══ --}}
<footer>
    <div class="footer-inner">
        <div class="footer-brand">
            <div class="logo" style="display:flex;align-items:center;gap:.6rem;margin-bottom:.5rem;">
                <div class="logo-icon" style="width:36px;height:36px;font-size:17px;">🛡️</div>
                <span class="logo-text">Sick Safe <span style="color:var(--teal)">ON</span></span>
            </div>
            <p>Platform digital untuk manajemen farmasi rumah sakit yang terintegrasi, aman, dan mudah digunakan.</p>
        </div>
        <div class="footer-col">
            <h4>Produk</h4>
            <a href="#">Resep Digital</a>
            <a href="#">Manajemen Obat</a>
            <a href="#">Pembayaran</a>
            <a href="#">Distribusi</a>
        </div>
        <div class="footer-col">
            <h4>Perusahaan</h4>
            <a href="#">Tentang Kami</a>
            <a href="#">Tim</a>
            <a href="#">Karier</a>
            <a href="#">Blog</a>
        </div>
        <div class="footer-col">
            <h4>Dukungan</h4>
            <a href="#">Dokumentasi</a>
            <a href="#">FAQ</a>
            <a href="#">Hubungi Kami</a>
            <a href="#">Kebijakan Privasi</a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} Sick Safe ON. Semua hak dilindungi. — <em>Innovating for Healthier Tomorrows</em></p>
    </div>
</footer>

<script src="{{ asset('js/homepage.js') }}"></script>

</body>
</html>