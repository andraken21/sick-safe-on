<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sick Safe ON – Innovating for Healthier Tomorrows</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal:       #0EA893;
            --teal-dark:  #0B8C7A;
            --teal-light: #E6FAF7;
            --navy:       #1A2B4A;
            --navy-mid:   #2D4168;
            --slate:      #5C7090;
            --muted:      #8FA3BE;
            --bg:         #F4F8FB;
            --white:      #FFFFFF;
            --border:     #DCE8F5;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--navy);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ── NAVBAR ─────────────────────────────────────── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            padding: 0 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--teal) 0%, var(--teal-dark) 100%);
            border-radius: 10px;
            display: grid; place-items: center;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(14,168,147,.35);
        }

        .logo-text { font-family: 'Sora', sans-serif; font-size: 1.15rem; font-weight: 700; color: var(--navy); }
        .logo-text span { color: var(--teal); }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            font-size: .9rem;
            font-weight: 500;
            color: var(--slate);
            transition: color .2s;
        }
        .nav-links a:hover { color: var(--teal); }

        .nav-actions { display: flex; gap: .75rem; align-items: center; }

        .btn-ghost {
            padding: .5rem 1.2rem;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            background: transparent;
            font-family: inherit;
            font-size: .88rem;
            font-weight: 600;
            color: var(--navy);
            cursor: pointer;
            transition: border-color .2s, color .2s;
            text-decoration: none;
        }
        .btn-ghost:hover { border-color: var(--teal); color: var(--teal); }

        .btn-primary {
            padding: .5rem 1.3rem;
            background: linear-gradient(135deg, var(--teal) 0%, var(--teal-dark) 100%);
            border: none;
            border-radius: 8px;
            font-family: inherit;
            font-size: .88rem;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(14,168,147,.3);
            transition: transform .18s, box-shadow .18s;
            text-decoration: none;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(14,168,147,.4); }

        .hamburger { display: none; background: none; border: none; cursor: pointer; padding: 4px; }
        .hamburger span { display: block; width: 24px; height: 2px; background: var(--navy); margin: 5px 0; border-radius: 2px; transition: .3s; }

        /* ── HERO ────────────────────────────────────────── */
        .hero {
            min-height: 88vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 4rem;
            padding: 5rem 5% 4rem;
            position: relative;
            overflow: hidden;
        }

        /* decorative blobs */
        .hero::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(14,168,147,.12) 0%, transparent 70%);
            top: -100px; right: -100px;
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(14,168,147,.08) 0%, transparent 70%);
            bottom: 0; left: 5%;
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            background: var(--teal-light);
            color: var(--teal-dark);
            font-size: .8rem;
            font-weight: 600;
            padding: .35rem .9rem;
            border-radius: 100px;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(14,168,147,.2);
        }
        .hero-badge .dot { width: 7px; height: 7px; background: var(--teal); border-radius: 50%; animation: pulse 1.8s infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }

        .hero-title {
            font-family: 'Sora', sans-serif;
            font-size: clamp(2rem, 3.5vw, 3rem);
            font-weight: 700;
            line-height: 1.2;
            color: var(--navy);
            margin-bottom: 1.25rem;
        }
        .hero-title .accent { color: var(--teal); }

        .hero-desc {
            font-size: 1rem;
            color: var(--slate);
            max-width: 480px;
            margin-bottom: 2rem;
            line-height: 1.75;
        }

        .hero-cta { display: flex; gap: 1rem; flex-wrap: wrap; }

        .btn-lg {
            padding: .85rem 2rem;
            font-size: .95rem;
            border-radius: 10px;
        }

        .btn-outline-lg {
            padding: .82rem 1.8rem;
            font-size: .95rem;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: var(--white);
            font-family: inherit;
            font-weight: 600;
            color: var(--navy);
            cursor: pointer;
            text-decoration: none;
            transition: border-color .2s, color .2s, box-shadow .2s;
        }
        .btn-outline-lg:hover { border-color: var(--teal); color: var(--teal); box-shadow: 0 4px 14px rgba(14,168,147,.15); }

        /* hero visual */
        .hero-visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: float 5s ease-in-out infinite;
        }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }

        .hero-card-wrap {
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 30px 80px rgba(26,43,74,.12);
            padding: 2.5rem;
            width: 100%;
            max-width: 460px;
            border: 1px solid var(--border);
            position: relative;
        }

        .card-header-bar {
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: 1.5rem;
        }
        .dot-red { width:10px;height:10px;background:#FF5F57;border-radius:50%; }
        .dot-yellow { width:10px;height:10px;background:#FEBC2E;border-radius:50%; }
        .dot-green { width:10px;height:10px;background:#28C840;border-radius:50%; }
        .card-title-bar { font-size:.8rem;font-weight:600;color:var(--slate);margin-left:.5rem; }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-box {
            background: var(--bg);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            border: 1px solid var(--border);
        }
        .stat-box .num { font-family:'Sora',sans-serif; font-size:1.6rem; font-weight:700; color:var(--navy); }
        .stat-box .lbl { font-size:.7rem; color:var(--muted); font-weight:500; margin-top:.2rem; }
        .stat-box.highlight { background:linear-gradient(135deg,var(--teal) 0%,var(--teal-dark) 100%); border-color:transparent; }
        .stat-box.highlight .num, .stat-box.highlight .lbl { color:#fff; }

        .resep-list { display:flex; flex-direction:column; gap:.6rem; }

        .resep-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--bg);
            border-radius: 10px;
            padding: .75rem 1rem;
            border: 1px solid var(--border);
        }
        .resep-item .ri-left { display:flex;align-items:center;gap:.7rem; }
        .resep-icon { width:34px;height:34px;background:var(--teal-light);border-radius:8px;display:grid;place-items:center;font-size:16px; }
        .resep-info .rnum { font-size:.82rem;font-weight:700;color:var(--navy); }
        .resep-info .rdoc { font-size:.72rem;color:var(--muted); }
        .badge { font-size:.68rem;font-weight:700;padding:.28rem .7rem;border-radius:100px; }
        .badge-success { background:#E6FBF3;color:#0BA876; }
        .badge-warning { background:#FFF8E6;color:#D97706; }

        /* floating mini-card */
        .float-card {
            position: absolute;
            background: var(--white);
            border-radius: 14px;
            box-shadow: 0 12px 40px rgba(26,43,74,.14);
            padding: .75rem 1.1rem;
            display: flex;
            align-items: center;
            gap: .6rem;
            border: 1px solid var(--border);
            white-space: nowrap;
            font-size: .8rem;
        }
        .float-card.top-left { top: -18px; left: -24px; animation: float 4s ease-in-out infinite .5s; }
        .float-card.bottom-right { bottom: -18px; right: -24px; animation: float 4s ease-in-out infinite 1s; }
        .float-icon { font-size:1.2rem; }
        .float-text strong { display:block; font-weight:700; color:var(--navy); font-size:.8rem; }
        .float-text span { color:var(--muted); font-size:.7rem; }

        /* ── FEATURES STRIP ──────────────────────────────── */
        .features-strip {
            padding: 3rem 5%;
            display: grid;
            grid-template-columns: repeat(4,1fr);
            gap: 1.5rem;
        }

        .feature-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.75rem 1.5rem;
            text-align: center;
            transition: transform .25s, box-shadow .25s, border-color .25s;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(14,168,147,.04) 0%, transparent 60%);
            opacity: 0;
            transition: opacity .3s;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(14,168,147,.12); border-color: rgba(14,168,147,.3); }
        .feature-card:hover::before { opacity: 1; }

        .feature-icon-wrap {
            width: 56px; height: 56px;
            background: var(--teal-light);
            border-radius: 14px;
            display: grid; place-items: center;
            margin: 0 auto 1rem;
            font-size: 24px;
            transition: background .3s;
        }
        .feature-card:hover .feature-icon-wrap { background: linear-gradient(135deg,var(--teal) 0%,var(--teal-dark) 100%); }

        .feature-title { font-size:.95rem; font-weight:700; color:var(--navy); margin-bottom:.4rem; }
        .feature-desc  { font-size:.82rem; color:var(--slate); line-height:1.6; }

        /* ── HOW IT WORKS ────────────────────────────────── */
        .section { padding: 5rem 5%; }
        .section-label { font-size:.8rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:var(--teal); margin-bottom:.75rem; }
        .section-title { font-family:'Sora',sans-serif; font-size:clamp(1.6rem,2.5vw,2.2rem); font-weight:700; color:var(--navy); margin-bottom:.75rem; }
        .section-sub { font-size:.95rem; color:var(--slate); max-width:540px; }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4,1fr);
            gap: 2rem;
            margin-top: 3rem;
            position: relative;
        }
        .steps-grid::before {
            content: '';
            position: absolute;
            top: 36px; left: calc(12.5% + 28px); right: calc(12.5% + 28px);
            height: 2px;
            background: repeating-linear-gradient(90deg, var(--teal) 0 10px, transparent 10px 20px);
        }

        .step {
            text-align: center;
            position: relative;
        }
        .step-num {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, var(--teal) 0%, var(--teal-dark) 100%);
            color: #fff;
            border-radius: 50%;
            display: grid; place-items: center;
            font-family: 'Sora', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            margin: 0 auto 1.25rem;
            box-shadow: 0 6px 18px rgba(14,168,147,.35);
            position: relative;
            z-index: 1;
        }
        .step-title { font-size:.95rem; font-weight:700; color:var(--navy); margin-bottom:.4rem; }
        .step-desc  { font-size:.82rem; color:var(--slate); }

        /* ── ROLES ───────────────────────────────────────── */
        .roles-section { background: var(--white); }
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(4,1fr);
            gap: 1.25rem;
            margin-top: 3rem;
        }
        .role-card {
            border-radius: 16px;
            padding: 2rem 1.5rem;
            border: 1.5px solid var(--border);
            transition: transform .25s, box-shadow .25s;
            cursor: default;
        }
        .role-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(26,43,74,.1); }
        .role-card.rc-pasien  { background: linear-gradient(135deg, #EBF9FF 0%, #F4F8FB 100%); border-color:#BEE3F8; }
        .role-card.rc-dokter  { background: linear-gradient(135deg, #F0FFF8 0%, #F4F8FB 100%); border-color:#B2F0DC; }
        .role-card.rc-apotek  { background: linear-gradient(135deg, #FFF8F0 0%, #F4F8FB 100%); border-color:#FED7AA; }
        .role-card.rc-admin   { background: linear-gradient(135deg, #F5F0FF 0%, #F4F8FB 100%); border-color:#D9B8FC; }

        .role-emoji { font-size: 2.2rem; margin-bottom: .75rem; }
        .role-title { font-size:1rem; font-weight:700; color:var(--navy); margin-bottom:.5rem; }
        .role-desc  { font-size:.82rem; color:var(--slate); line-height:1.65; }

        /* ── STATS BAND ──────────────────────────────────── */
        .stats-band {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
            padding: 4rem 5%;
            display: grid;
            grid-template-columns: repeat(4,1fr);
            gap: 2rem;
            text-align: center;
        }
        .stat-item .big { font-family:'Sora',sans-serif; font-size:2.4rem; font-weight:700; color:#fff; }
        .stat-item .big span { color:var(--teal); }
        .stat-item .lbl { font-size:.85rem; color: rgba(255,255,255,.6); margin-top:.25rem; }

        /* ── CTA SECTION ─────────────────────────────────── */
        .cta-section {
            padding: 6rem 5%;
            text-align: center;
            background: var(--bg);
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(14,168,147,.1) 0%, transparent 65%);
            top: 50%; left: 50%;
            transform: translate(-50%,-50%);
            pointer-events: none;
        }
        .cta-section .section-title { margin: 0 auto .75rem; }
        .cta-section .section-sub   { margin: 0 auto 2.5rem; text-align:center; }
        .cta-section .btn-primary.btn-lg { display:inline-block; }

        /* ── FOOTER ──────────────────────────────────────── */
        footer {
            background: var(--navy);
            color: rgba(255,255,255,.65);
            padding: 3rem 5% 1.5rem;
        }
        .footer-inner {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 2.5rem;
        }
        .footer-brand .logo-text { color:#fff; font-size:1.05rem; }
        .footer-brand p { font-size:.82rem; margin-top:.75rem; line-height:1.7; max-width:260px; }
        .footer-col h4 { color:#fff; font-size:.88rem; font-weight:700; margin-bottom:1rem; }
        .footer-col a { display:block; color:rgba(255,255,255,.55); text-decoration:none; font-size:.82rem; margin-bottom:.5rem; transition:color .2s; }
        .footer-col a:hover { color:var(--teal); }
        .footer-bottom { border-top:1px solid rgba(255,255,255,.1); padding-top:1.25rem; text-align:center; font-size:.78rem; }

        /* ── RESPONSIVE ──────────────────────────────────── */
        @media (max-width: 1024px) {
            .steps-grid::before { display:none; }
            .steps-grid, .roles-grid { grid-template-columns: repeat(2,1fr); }
            .stats-band { grid-template-columns: repeat(2,1fr); }
            .footer-inner { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .hero { grid-template-columns: 1fr; gap:3rem; padding: 3rem 5%; text-align:center; }
            .hero-desc { max-width:100%; }
            .hero-cta { justify-content:center; }
            .hero-visual { order:-1; }
            .hero::before, .hero::after { display:none; }
            .float-card { display:none; }
            .features-strip { grid-template-columns: repeat(2,1fr); }
            .steps-grid { grid-template-columns: 1fr 1fr; }
            .roles-grid { grid-template-columns: 1fr 1fr; }
            .stats-band { grid-template-columns: 1fr 1fr; }
            .nav-links, .nav-actions { display:none; }
            .hamburger { display:block; }
            .footer-inner { grid-template-columns: 1fr; gap:2rem; }
        }

        @media (max-width: 480px) {
            .features-strip, .steps-grid, .roles-grid, .stats-band { grid-template-columns:1fr; }
        }
    </style>
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

<script>
    // Hamburger toggle (simple, no Alpine/jQuery needed)
    const hamburger = document.querySelector('.hamburger');
    const navLinks  = document.querySelector('.nav-links');
    const navAct    = document.querySelector('.nav-actions');

    hamburger.addEventListener('click', () => {
        const open = navLinks.style.display === 'flex';
        navLinks.style.cssText = open ? '' : 'display:flex;flex-direction:column;position:absolute;top:68px;left:0;right:0;background:#fff;padding:1.5rem 5%;gap:1rem;border-bottom:1px solid var(--border);z-index:99;';
        navAct.style.cssText   = open ? '' : 'display:flex;flex-direction:row;position:absolute;top:calc(68px + 10rem);left:0;right:0;background:#fff;padding:1rem 5% 1.5rem;gap:.75rem;z-index:99;';
    });

    // Smooth active nav highlight
    const sections = document.querySelectorAll('section[id], div[id]');
    const links    = document.querySelectorAll('.nav-links a');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                links.forEach(l => l.style.color = '');
                const active = document.querySelector(`.nav-links a[href="#${entry.target.id}"]`);
                if (active) active.style.color = 'var(--teal)';
            }
        });
    }, { threshold: 0.4 });

    sections.forEach(s => observer.observe(s));
</script>

</body>
</html>