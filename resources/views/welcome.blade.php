<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Monitoring Pelanggaran Siswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* ==== Token system — derived from SMPN 216's own facade ==== */
            --navy: #16324B;        /* dark blue structural bands on the building */
            --blue: #4E8FC4;        /* sky‑blue panel colour */
            --blue-soft: #DCEBF6;   /* pale tint of the facade blue */
            --bg: #F5F9FC;          /* near‑white background, faint blue cast */
            --white: #FFFFFF;
            --leaf: #4C7A52;        /* balcony planter greenery */
            --leaf-soft: #E5EFE6;
            --ink: #16324B;
            --ink-soft: #5B7186;
            --line: #D8E6F0;
            --max: 1120px;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: var(--bg);
            color: var(--ink);
            font-family: 'Inter', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        a { color: inherit; text-decoration: none; }

        h1, h2, .serif { font-family: 'Source Serif 4', Georgia, serif; }

        .page-wrap {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background:
                linear-gradient(180deg, var(--blue-soft) 0%, var(--bg) 260px);
        }

        .container {
            max-width: var(--max);
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 1;
            width: 100%;
        }

        /* ============ Masthead ============ */
        .masthead-bar {
            background: var(--navy);
            color: #EAF2F8;
            font-size: 12px;
            letter-spacing: .4px;
            padding: 7px 0;
        }
        .masthead-bar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .masthead-bar .tag {
            opacity: .85;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 0;
            border-bottom: 1px solid var(--line);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-mark {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 1.5px solid var(--line);
        }

        .brand-mark img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-text { line-height: 1.25; }

        .brand-text .school-name {
            font-family: 'Source Serif 4', Georgia, serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--navy);
        }

        .brand-text .school-sub {
            font-size: 11.5px;
            font-weight: 500;
            letter-spacing: .3px;
            text-transform: uppercase;
            color: var(--ink-soft);
        }

        .nav-actions { display: flex; gap: 10px; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 11px 26px;
            border-radius: 4px;
            font-size: 13.5px;
            font-weight: 600;
            border: 1.5px solid var(--navy);
            cursor: pointer;
            transition: transform .12s ease, background .15s ease, color .15s ease;
            white-space: nowrap;
        }
        .btn:active { transform: scale(0.98); }

        .btn-solid { background: var(--navy); color: #fff; border-color: var(--navy); }
        .btn-solid:hover { background: #0E2338; }

        .btn-outline { background: transparent; color: var(--navy); }
        .btn-outline:hover { background: var(--navy); color: #fff; }

        /* ============ Photo banner ============ */
        .banner {
            position: relative;
            width: 100%;
            min-height: 480px;
            display: flex;
            align-items: flex-end;
            background: url('{{ asset("gedung_216.jpeg") }}') center/cover no-repeat;
            overflow: hidden;
        }
        .banner::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(22,50,75,0.35) 0%, rgba(22,50,75,0.7) 55%, rgba(22,50,75,0.92) 100%);
        }
        .banner::after {
            content: "";
            position: absolute;
            left: 0; right: 0; bottom: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 50%, var(--leaf) 100%);
        }
        .banner-content {
            position: relative;
            z-index: 1;
            width: 100%;
            padding: 48px 0 42px;
            color: #fff;
        }
        .banner .hero-tag {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.35);
            color: #EAF2F8;
            backdrop-filter: blur(2px);
        }
        .banner .hero-tag .dot { background: #8FD19E; }

        /* Banner text colors — high specificity so these always win over the
           default .hero rules below (which are dark, meant for non-banner use) */
        .banner .hero h1 {
            color: #fff;
            text-shadow: 0 2px 10px rgba(0,0,0,0.45);
        }
        .banner .hero h1 .accent { color: #9BC9EA; }
        .banner .hero p.lead {
            color: #EAF2F8;
            max-width: 520px;
            text-shadow: 0 1px 6px rgba(0,0,0,0.35);
        }
        .banner .hero-note {
            background: rgba(255,255,255,0.94);
        }

        /* ============ Hero (text block inside banner) ============ */
        .hero {
            flex: 1;
            max-width: 620px;
            padding: 0;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: 3px;
            padding: 7px 14px;
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: var(--navy);
            margin-bottom: 22px;
        }
        .hero-tag .dot { width: 7px; height: 7px; border-radius: 50%; background: var(--leaf); }

        .hero h1 {
            font-size: 46px;
            line-height: 1.22;
            margin: 0 0 20px;
            font-weight: 600;
            letter-spacing: -0.3px;
            color: var(--navy);
        }

        .hero h1 .accent { color: var(--blue); }

        .hero p.lead {
            font-size: 15.5px;
            color: var(--ink-soft);
            max-width: 440px;
            margin: 0 0 32px;
            line-height: 1.8;
        }

        .hero-actions { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 28px; }

        .hero-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            max-width: 440px;
            padding: 14px 16px;
            background: var(--white);
            border: 1px solid var(--line);
            border-left: 3px solid var(--blue);
            border-radius: 3px;
            font-size: 12.5px;
            color: var(--ink-soft);
            line-height: 1.6;
        }
        .hero-note svg { flex-shrink: 0; margin-top: 2px; }

        /* ============ Info strip ============ */
        .info-strip {
            border-top: 1px solid var(--line);
            background: var(--white);
            padding: 34px 0 40px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }
        .info-card { display: flex; gap: 14px; align-items: flex-start; }
        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--blue-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .info-card h3 {
            margin: 0 0 4px;
            font-size: 14px;
            font-weight: 600;
            color: var(--navy);
        }
        .info-card p {
            margin: 0;
            font-size: 12.5px;
            line-height: 1.6;
            color: var(--ink-soft);
        }

        /* ============ Footer ============ */
        footer {
            text-align: center;
            padding: 18px 0;
            font-size: 11.5px;
            color: var(--ink-soft);
            background: var(--navy);
            color: #B9CADA;
        }

        /* ============ Mobile ============ */
        @media (max-width: 900px) {
            .container { padding: 0 20px; }

            /* Masthead — stack the two tags, drop the noise */
            .masthead-bar { padding: 6px 0; }
            .masthead-bar .container {
                flex-direction: column;
                gap: 1px;
                text-align: center;
            }
            .masthead-bar .tag:last-child { display: none; } /* keep only the primary line on small screens */

            /* Topbar — just the logo + Masuk/Daftar, no wrapping */
            .topbar { padding: 14px 0; }
            .brand-mark { width: 42px; height: 42px; }
            .brand-text { display: none; }
            .nav-actions { gap: 8px; }
            .nav-actions .btn { padding: 9px 16px; font-size: 12.5px; }

            /* Banner */
            .banner { min-height: 0; }
            .banner-content { padding: 36px 0 32px; }
            .hero { max-width: 100%; text-align: center; }
            .hero-tag { margin: 0 auto 18px; }
            .hero h1 { font-size: 30px; margin: 0 0 16px; }
            .hero p.lead {
                font-size: 14.5px;
                line-height: 1.7;
                margin: 0 auto 26px;
            }
            .hero-actions { justify-content: center; margin-bottom: 22px; }
            .hero-note {
                margin: 0 auto;
                text-align: left;
                max-width: 100%;
            }

            /* Info strip — stack cards, give each one breathing room */
            .info-strip { padding: 30px 0 34px; }
            .info-grid { grid-template-columns: 1fr; gap: 22px; }
            .info-card {
                gap: 12px;
                padding-bottom: 22px;
                border-bottom: 1px solid var(--line);
            }
            .info-card:last-child { border-bottom: none; padding-bottom: 0; }
        }

        @media (max-width: 480px) {
            .masthead-bar .tag { font-size: 10.5px; }


            .banner-content { padding: 30px 0 26px; }
            .hero h1 { font-size: 25px; line-height: 1.28; }
            .hero p.lead { font-size: 13.5px; }
            .hero-note { font-size: 12px; padding: 12px 14px; }

            .btn { padding: 11px 18px; font-size: 13px; }
            .hero-actions { flex-direction: column; width: 100%; gap: 10px; }
            .hero-actions .btn { width: 100%; }

            .nav-actions .btn { padding: 8px 13px; font-size: 12px; }

            .info-icon { width: 36px; height: 36px; }
            .info-card h3 { font-size: 13.5px; }
            .info-card p { font-size: 12px; }

            footer { font-size: 10.5px; padding: 14px 0; }
        }
    </style>
</head>
<body>

    <div class="page-wrap">

        {{-- Formal masthead strip --}}
        <div class="masthead-bar">
            <div class="container">
                <span class="tag">Dinas Pendidikan Provinsi DKI Jakarta</span>
                <span class="tag">Layanan Bimbingan &amp; Konseling</span>
            </div>
        </div>

        <div class="container">
            {{-- Top bar --}}
            <div class="topbar">
                <div class="brand">
                    <div class="brand-mark">
                        <img src="{{ asset('logo-smpn216.png') }}" alt="Logo SMPN 216 Jakarta">
                    </div>
                    <div class="brand-text">
                        <div class="school-name">SMPN 216 Jakarta</div>
                        <div class="school-sub">Portal Skrining Kesehatan Mental</div>
                    </div>
                </div>
                <div class="nav-actions">
                    @auth
                        @if(Auth::user()->role === 'guru')
                            <a href="/dashboard" class="btn btn-solid">Dashboard</a>
                        @else
                            <a href="/dashboard-siswa" class="btn btn-solid">Dashboard Saya</a>
                        @endif
                    @else
                       <a
    href="{{ route('login') }}"
>
    Login Guru BK
</a>

<a
    href="{{ route('public.lookup') }}"
>
    Cek Data Siswa
</a>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Photo banner --}}
        <section class="banner">
            <div class="banner-content">
                <div class="container">
                    <div class="hero">
                        <span class="hero-tag"><span class="dot"></span> Instrumen Skrining SDQ</span>
                        <h1>Skrining<br>Kesehatan <span class="accent">Mental</span><br>Siswa SMPN 216</h1>
                        <p class="lead">
                            Layanan skrining kesehatan mental resmi bagi seluruh siswa SMPN 216 Jakarta,
                            menggunakan instrumen Strengths and Difficulties Questionnaire (SDQ). Proses
                            pengisian berlangsung singkat dan hasil skrining bersifat rahasia.
                        </p>
                        <div class="hero-actions">
                            @auth
                                <a href="/sdq" class="btn btn-solid">Mulai Skrining</a>
                            @else
                                <a href="/register" class="btn btn-solid">Daftar Sekarang</a>
                            @endauth
                        </div>
                        <div class="hero-note">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L3 6v6c0 5 3.8 8.7 9 10 5.2-1.3 9-5 9-10V6l-9-4z" stroke="#4E8FC4" stroke-width="1.6" stroke-linejoin="round"/>
                            </svg>
                            <span>Kerahasiaan data terjamin. Hasil skrining hanya dapat diakses oleh Guru Bimbingan &amp; Konseling (BK).</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Info strip --}}
        <div class="info-strip">
            <div class="container">
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12l2 2 4-4" stroke="#16324B" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="9" stroke="#16324B" stroke-width="1.6"/>
                            </svg>
                        </div>
                        <div>
                            <h3>Instrumen Tervalidasi</h3>
                            <p>Menggunakan Strengths and Difficulties Questionnaire (SDQ) yang telah teruji secara akademis.</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="4" y="4" width="16" height="16" rx="2" stroke="#16324B" stroke-width="1.6"/>
                                <path d="M8 2v4M16 2v4M4 10h16" stroke="#16324B" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div>
                            <h3>Proses Singkat</h3>
                            <p>Skrining dapat diselesaikan dalam waktu kurang lebih 10–15 menit melalui perangkat sekolah maupun pribadi.</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L3 6v6c0 5 3.8 8.7 9 10 5.2-1.3 9-5 9-10V6l-9-4z" stroke="#16324B" stroke-width="1.6" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <h3>Data Terlindungi</h3>
                            <p>Seluruh hasil bersifat rahasia dan hanya dapat ditinjau oleh Guru Bimbingan &amp; Konseling (BK).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <footer>
            © 2025 SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa
        </footer>

    </div>

</body>
</html>