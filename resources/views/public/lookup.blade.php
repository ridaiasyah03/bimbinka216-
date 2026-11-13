<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Data Siswa — Dashboard Pelanggaran Siswa</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-smpn216.png') }}">
    <meta name="description" content="Portal publik pencarian data siswa berdasarkan NIS">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,600;8..60,700&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --navy: #16324B;
            --navy-dark: #0F2436;
            --blue: #4E8FC4;
            --blue-dark: #3D7AAB;
            --blue-soft: #DCEBF6;
            --line: #D8E6F0;
            --ink-soft: #5B7186;
            --green: #4C7A52;
            --green-soft: #E7F0E8;
            --cream: #F7FAFC;
        }
        body { font-family: 'Inter', sans-serif; }
        .serif { font-family: 'Source Serif 4', Georgia, serif; }
        .glow { box-shadow: 0 0 60px rgba(22,50,75,0.18); }
        .fade-in { animation: fadeIn .6s ease-out; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
        .shimmer { background: linear-gradient(135deg, rgba(22,50,75,.08) 0%, rgba(78,143,196,.06) 50%, rgba(22,50,75,.08) 100%); }

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
        .masthead-bar .tag { opacity: .85; }
        @media (max-width: 640px) {
            .masthead-bar .container { flex-direction: column; gap: 1px; text-align: center; }
            .masthead-bar .tag:last-child { display: none; }
        }
        .masthead-bar .tag { opacity: .85; }
        @media (max-width: 640px) {
            .masthead-bar .container { flex-direction: column; gap: 1px; text-align: center; }
            .masthead-bar .tag:last-child { display: none; }
        }

        @media (max-width: 380px) {
            .brand-subtitle { font-size: 10px; }
            .brand-title { font-size: 12px; }
        }

        .brand-mark {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 1.5px solid var(--line);
        }
        .brand-mark img { width: 100%; height: 100%; object-fit: contain; }

        .brand-title { color: var(--navy); }
        .brand-subtitle { color: var(--blue-dark); }

        .btn-login-guru {
            background: transparent;
            color: var(--navy);
            border: 1.5px solid var(--navy);
            transition: background .15s ease, color .15s ease, border-color .15s ease;
        }
        .btn-login-guru:hover {
            background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 100%);
            color: #fff;
            border-color: transparent;
        }


        .school-banner {
            position: relative;
            width: 100%;
            min-height: 560px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('{{ asset("gedung_216.jpeg") }}') center/cover no-repeat;
            overflow: hidden;
            padding: 32px 24px;
        }
        .school-banner::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 720px 400px at 50% 30%, rgba(11,26,39,0.82) 0%, rgba(11,26,39,0.4) 58%, rgba(11,26,39,0) 100%),
                linear-gradient(180deg, rgba(22,50,75,0.62) 0%, rgba(22,50,75,0.8) 100%);
        }
        .school-banner::after {
            content: "";
            position: absolute;
            left: 0; right: 0; bottom: 0;
            height: 4px;
            background: linear-gradient(90deg, #16324B 0%, #4E8FC4 60%, #4C7A52 100%);
        }
        .school-banner-content {
            position: relative;
            z-index: 1;
            width: 100%;
        }
        .school-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: #EAF2F8;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.28);
            backdrop-filter: blur(6px);
            padding: 6px 18px;
            border-radius: 999px;
            margin-bottom: 10px;
        }
        .school-eyebrow-line { width: 14px; height: 1px; background: rgba(255,255,255,.55); }
        .school-title {
            font-family: 'Source Serif 4', Georgia, serif;
            font-weight: 700;
            font-size: 32px;
            letter-spacing: .03em;
            color: #fff;
            text-shadow: 0 2px 16px rgba(0,0,0,0.5);
            margin: 0 0 10px;
        }
        .school-title-accent { color: #AFCFEA; }
        .school-subtitle {
            font-size: 12.5px;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: #CFE1EF;
            text-shadow: 0 1px 6px rgba(0,0,0,0.35);
            display: inline-block;
            padding-bottom: 13px;
            position: relative;
            margin: 0;
        }
        .school-subtitle::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 44px;
            height: 2px;
            border-radius: 2px;
            background: linear-gradient(90deg, var(--blue) 0%, var(--green) 100%);
        }
        @media (max-width: 480px) {
            .school-title { font-size: 26px; }
        }
        .search-card {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(6px);
            border-radius: 24px;
            padding: 40px 32px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.35);
        }
        @media (max-width: 625px) {
            .school-banner { min-height: 560px; padding: 28px 16px; }
            .school-label h2 { font-size: 18px; }
            .search-card { padding: 28px 20px; }
        }

        /* ---------- Section tambahan ---------- */
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--blue);
            background: var(--blue-soft);
            padding: 5px 12px;
            border-radius: 999px;
        }

        /* Fitur Utama */
        .feature-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 26px 22px;
            transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
        }
        .feature-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 32px rgba(22,50,75,0.08);
            border-color: var(--blue);
        }
        .feature-icon {
            width: 42px; height: 42px;
            border-radius: 12px;
            background: var(--blue-soft);
            color: var(--navy);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
        }

        /* Cara kerja (side-by-side) */
        .step-row {
            display: flex;
            gap: 16px;
            padding-bottom: 26px;
            position: relative;
        }
        .step-row:last-child { padding-bottom: 0; }
        .step-row::before {
            content: "";
            position: absolute;
            left: 17px;
            top: 38px;
            bottom: 0;
            width: 1px;
            background: var(--line);
        }
        .step-row:last-child::before { display: none; }
        .step-dot {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: var(--navy);
            color: #fff;
            font-weight: 800;
            font-size: 13px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            z-index: 1;
        }
        .device-panel {
            background: var(--navy);
            border-radius: 22px;
            padding: 22px;
            box-shadow: 0 24px 50px rgba(22,50,75,0.25);
        }
        .device-screen {
            background: #fff;
            border-radius: 16px;
            padding: 22px;
        }
        .device-dots span {
            width: 8px; height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        .skel-bar { background: var(--blue-soft); border-radius: 999px; height: 8px; }
        .skel-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--line); }
        .skel-row:last-child { border-bottom: none; }
        .kpi-pill {
            background: var(--green-soft);
            color: var(--green);
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 999px;
        }

        /* FAQ */
        .faq-item {
            border-bottom: 1px solid var(--line);
        }
        .faq-item:last-child { border-bottom: none; }
        .faq-item summary {
            cursor: pointer;
            list-style: none;
            padding: 18px 4px;
            font-weight: 600;
            color: var(--navy);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .faq-item summary::-webkit-details-marker { display: none; }
        .faq-item .chev { transition: transform .2s ease; color: var(--blue); flex-shrink: 0; }
        .faq-item[open] .chev { transform: rotate(180deg); }
        .faq-item p {
            padding: 0 4px 18px;
            color: var(--ink-soft);
            font-size: 14px;
            line-height: 1.65;
        }

        /* Testimoni */
        .testi-card {
            background: var(--green-soft);
            border-radius: 22px;
            padding: 36px 30px;
            position: relative;
        }
        .testi-quote-mark {
            font-family: 'Source Serif 4', Georgia, serif;
            font-size: 64px;
            line-height: 0;
            color: var(--green);
            opacity: .35;
            display: block;
            margin-bottom: 6px;
        }

        /* Hubungi kami */
        .contact-row {
            display: flex;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid var(--line);
        }
        .contact-row:last-child { border-bottom: none; }
        .contact-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: var(--blue-soft);
            color: var(--navy);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .map-frame {
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--line);
            height: 100%;
            min-height: 280px;
        }
        .map-frame iframe { width: 100%; height: 100%; min-height: 280px; display: block; border: 0; }

       /* Footer */
        .site-footer {
            background: var(--navy);
            color: #9FB4C7;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1.2fr;
            gap: 40px;
            max-width: 1024px;
            margin: 0 auto;
            padding: 56px 24px;
        }
        @media (max-width: 700px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 32px 24px;
            }
        }
        @media (max-width: 460px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
        .site-footer .footer-col p.footer-brand {
            color: #fff;
            font-weight: 600;
            font-size: 14.5px;
            margin: 0 0 14px;
        }
        .site-footer .footer-col p {
            font-size: 13.5px;
            line-height: 1.75;
            margin: 0 0 6px;
            color: #9FB4C7;
        }
        .site-footer .footer-col p:last-child { margin-bottom: 0; }
        .site-footer h4 {
            color: #fff;
            font-weight: 600;
            font-size: 14.5px;
            margin: 0 0 18px;
        }
        .site-footer ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 13px;
        }
        .site-footer a {
            color: #9FB4C7;
            font-size: 13.5px;
            transition: color .15s ease;
        }
        .site-footer a:hover { color: #fff; }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
        }


        .icon-badge {
            background: linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%);
            box-shadow: 0 20px 40px rgba(22,50,75,0.3);
        }
        .btn-search {
            background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 100%);
            box-shadow: 0 15px 30px rgba(22,50,75,0.25);
            transition: background .2s ease;
        }
        .btn-search:hover {
            background: linear-gradient(90deg, var(--navy-dark) 0%, var(--blue-dark) 100%);
        }
        .input-brand:focus {
            border-color: var(--blue) !important;
            box-shadow: 0 0 0 3px rgba(78,143,196,0.25);
            outline: none;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="border-b border-slate-200 bg-white/80 backdrop-blur-md sticky top-0 z-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between gap-3">
        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
            <div class="brand-mark">
                <img src="{{ asset('logo-smpn216.png') }}" alt="Logo SMPN 216 Jakarta">
            </div>
            <div class="min-w-0">
                 <span class="brand-title font-bold text-sm tracking-wide block truncate">SMPN 216 JAKARTA</span>
                <p class="brand-subtitle text-xs font-semibold truncate">Sistem Monitoring Pembinaan Siswa</p>
            </div>
        </div>
        <a href="{{ route('login') }}" class="btn-login-guru text-xs font-semibold px-3 sm:px-4 py-2 rounded-lg transition-colors whitespace-nowrap flex-shrink-0">
            Login Guru BK
        </a>
    </div>
    </header>
    {{-- Banner foto gedung + Cek Data Siswa (mengambang di atas foto) --}}
    <section class="school-banner">
        <div class="school-banner-content max-w-lg mx-auto">
            <div class="school-label text-center mb-5 fade-in">
                <div class="school-eyebrow">
                    <span class="school-eyebrow-line"></span>
                    Portal Layanan Bimbingan Konseling 
                    <span class="school-eyebrow-line"></span>
                </div>
                <h2 class="school-title">SMPN 216 <span class="school-title-accent">JAKARTA</span></h2>
                <p class="school-subtitle">Sistem Monitoring Pembinaan Siswa </p>
            </div>

            <div class="search-card fade-in">
                {{-- Icon --}}
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <div class="w-24 h-24 rounded-3xl icon-badge flex items-center justify-center glow">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-xl bg-emerald-500 flex items-center justify-center shadow-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>
                </div>

                <h1 class="text-3xl font-black text-slate-800 text-center mb-2 tracking-tight">Cek Data Siswa</h1>
                <p class="text-slate-500 text-center text-sm mb-8 leading-relaxed">
                    Masukkan <span class="font-semibold" style="color:var(--blue-dark)">NIS</span> untuk melihat profil, riwayat pelanggaran, dan skor Pelanggaran siswa.
                </p>

                {{-- Search Form --}}
                @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl text-sm font-medium">
                    ✅ {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('public.lookup.search') }}" class="space-y-4">
                    @csrf
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="query" id="queryInput"
                               value="{{ old('query') }}"
                               placeholder="Contoh: 19000"
                               autocomplete="off"
                               class="w-full input-brand bg-white border {{ $errors->has('query') ? 'border-red-500' : 'border-slate-300' }} text-slate-700 text-base rounded-2xl pl-12 pr-4 py-4 focus:outline-none placeholder-slate-400 transition-colors">
                    </div>

                    @if($errors->has('query'))
                    <div class="flex items-center gap-2 text-red-400 text-sm">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        {{ $errors->first('query') }}
                    </div>
                    @endif

                    <button type="submit" id="searchBtn"
                            class="w-full btn-search text-white font-bold py-4 rounded-2xl transition-all text-base">
                        Cari Data Siswa
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- Fitur Utama --}}
    <section id="fitur" class="py-16 px-6 bg-white">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10">
                <span class="section-label">Fitur Utama</span>
                <h3 class="serif text-2xl md:text-3xl font-bold text-slate-800 mt-3">Kenapa memakai sistem ini</h3>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-800 mb-1.5 text-sm">Pencatatan Terpusat</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Seluruh riwayat pelanggaran siswa tersimpan dalam satu sistem sehingga mudah ditelusuri berdasarkan NIS.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-800 mb-1.5 text-sm">Skor Pelanggaran Otomatis</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Skor Pelanggaran dihitung secara otomatis berdasarkan data pelanggaran sebagai acuan pembinaan oleh Guru BK.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-800 mb-1.5 text-sm">Dashboard Analitik BK</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Guru BK dapat memantau tren pelanggaran siswa melalui dashboard analitik secara real-time.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-800 mb-1.5 text-sm">Privasi &amp; Keamanan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Data siswa hanya dapat diakses menggunakan NIS yang valid dan dikelola oleh Guru BK yang berwenang.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Cara Kerja (side-by-side) --}}
    <section id="cara-kerja" class="py-16 px-6" style="background: var(--cream);">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="section-label">Alur Penggunaan Cek Data Siswa</span>
                <h3 class="serif text-2xl md:text-3xl font-bold text-slate-800 mt-3 mb-8">Tiga langkah sederhana</h3>

                <div class="step-row">
                    <div class="step-dot">1</div>
                    <div>
                        <h4 class="font-bold text-slate-800 mb-1 text-sm">Masukkan NIS</h4>
                        <p class="text-sm text-slate-500 leading-relaxed">Ketik Nomor Induk Siswa pada kolom pencarian di bagian atas halaman.</p>
                    </div>
                </div>
                <div class="step-row">
                    <div class="step-dot">2</div>
                    <div>
                        <h4 class="font-bold text-slate-800 mb-1 text-sm">Sistem memverifikasi</h4>
                        <p class="text-sm text-slate-500 leading-relaxed">Data dicocokkan dengan catatan yang sudah diinput oleh Guru BK.</p>
                    </div>
                </div>
                <div class="step-row">
                    <div class="step-dot">3</div>
                    <div>
                        <h4 class="font-bold text-slate-800 mb-1 text-sm">Lihat hasilnya</h4>
                        <p class="text-sm text-slate-500 leading-relaxed">Profil, riwayat pelanggaran, dan skor Pelanggaran siswa langsung ditampilkan.</p>
                    </div>
                </div>
            </div>

            {{-- Mockup visual di samping --}}
            <div class="device-panel">
                <div class="device-dots mb-3">
                    <span style="background:#F87171"></span><span style="background:#FBBF24"></span><span style="background:#34D399"></span>
                </div>
                <div class="device-screen">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl icon-badge"></div>
                        <div class="flex-1">
                            <div class="skel-bar" style="width:60%"></div>
                            <div class="skel-bar mt-2" style="width:35%; opacity:.6"></div>
                        </div>
                    </div>
                    <div class="skel-row">
                        <span class="text-xs text-slate-500">Overall Score</span>
                        <span class="kpi-pill">4.29</span>
                    </div>
                    <div class="skel-row">
                        <span class="text-xs text-slate-500">Riwayat Pelanggaran</span>
                        <span class="text-xs font-bold text-slate-700"> 1 catatan</span>
                    </div>
                    <div class="skel-row">
                        <span class="text-xs text-slate-500"> Tren Pelanggaran Bulanan </span>
                        <span class="kpi-pill">1.0</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="py-16 px-6 bg-white">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-8">
                <span class="section-label">Pertanyaan Umum</span>
                <h3 class="serif text-2xl md:text-3xl font-bold text-slate-800 mt-3">Sering ditanyakan</h3>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl px-5">
                <details class="faq-item" open>
                    <summary>
                        Bagaimana cara mencari data saya?
                        <svg class="chev w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p>Masukkan NIS pada kolom pencarian di halaman utama, lalu klik "Cari Data Siswa". Profil dan riwayat pelanggaran akan ditampilkan jika NIS ditemukan.</p>
                </details>
                <details class="faq-item">
                    <summary>
                        Apakah data saya aman?
                        <svg class="chev w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p>Halaman ini hanya bisa menampilkan data, tidak untuk mengubah atau menghapus. Pengelolaan dan pengeditan data hanya dapat dilakukan oleh Guru BK yang sudah login.</p>
                </details>
                <details class="faq-item">
                    <summary>
                        Kenapa NIS saya tidak ditemukan?
                        <svg class="chev w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p>Kemungkinan NIS yang dimasukkan keliru, atau data belum diinput oleh Guru BK. Silakan periksa kembali atau hubungi BK melalui kontak di bawah.</p>
                </details>
                <details class="faq-item">
                    <summary>
                        Apa itu skor Pelanggaran Siswa?
                        <svg class="chev w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p>Skor Pelanggaran Siswa adalah indikator yang dihitung dari akumulasi jenis dan jumlah pelanggaran siswa, digunakan sebagai acuan pembinaan oleh Guru BK.</p>
                </details>
            </div>
        </div>
    </section>

    {{-- Tujuan Sistem --}}
    <section class="py-16 px-6" style="background: var(--cream);">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-8">
                <span class="section-label">TUJUAN SISTEM</span>
                <h3 class="serif text-2xl md:text-3xl font-bold text-slate-800 mt-3">Mendukung Pembinaan Siswa</h3>
            </div>
            <div class="testi-card">
                <span class="testi-quote-mark">&ldquo;</span>
                <p class="serif text-lg md:text-xl text-slate-700 leading-relaxed -mt-2">
                    Sistem ini dirancang untuk membantu Guru BK dalam memantau perkembangan perilaku siswa, mendukung proses pembinaan, 
                    serta meningkatkan komunikasi antara sekolah dan orang tua melalui informasi yang transparan dan mudah diakses.
            </div>
        </div>
    </section>

    {{-- Hubungi Kami --}}
    <section class="py-16 px-6 bg-white">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10">
                <span class="section-label">Hubungi Kami</span>
                <h3 class="serif text-2xl md:text-3xl font-bold text-slate-800 mt-3"></h3>
            </div>
            <div class="grid md:grid-cols-2 gap-6 items-stretch">
                <div class="bg-white border border-slate-200 rounded-2xl p-7">
                    <div class="contact-row">
                        <div class="contact-icon">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Alamat Sekolah</p>
                            <p class="text-sm text-slate-500 leading-relaxed">Jl. Salemba Raya No. 18, RW.4, Kenari, Kec. Senen, Kota Jakarta Pusat, DKI Jakarta 10430</p>
                        </div>
                    </div>
                    <div class="contact-row">
                        <div class="contact-icon">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Telepon / WhatsApp BK</p>
                            <p class="text-sm text-slate-500">(021)31931857 &middot; 0896-4475-2177</p>
                        </div>
                    </div>
                    <div class="contact-row">
                        <div class="contact-icon">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linaecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Email</p>
                            <p class="text-sm text-slate-500">smpn216_jp@yahoo.co.id</p>
                        </div>
                    </div>
                    <div class="contact-row">
                        <div class="contact-icon">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Jam Layanan BK</p>
                            <p class="text-sm text-slate-500">Senin – Jumat, 08.00 – 15.00 WIB</p>
                        </div>
                    </div>
                </div>
                <div class="map-frame">
                    <iframe
                        src="https://www.google.com/maps?q=Jl.+Salemba+Raya+No.+18+Kenari+Senen+Jakarta+Pusat&output=embed"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
<footer class="site-footer mt-auto">
    <div class="footer-grid">

        {{-- Tentang --}}
        <div class="footer-col">
            <p class="footer-brand">SMPN 216 Jakarta</p>
            <p>Dashboard Monitoring &amp; Skor Pelanggaran Siswa Terintegrasi.</p>
            <p>SMP Negeri 216 Jakarta.</p>
        </div>

        {{-- Navigasi --}}
        <div class="footer-col">
            <h4>Navigasi</h4>
            <ul>
                <li><a href="#fitur">Fitur Utama</a></li>
                <li><a href="#cara-kerja">Alur Penggunaan Cek Data Siswa</a></li>
                <li><a href="#faq">Pertanyaan Umum (FAQ)</a></li>
            </ul>
        </div>

        {{-- Akses --}}
        <div class="footer-col">
            <h4>Akses</h4>
            <ul>
                <li><a href="{{ route('login') }}">Login Guru BK</a></li>
                <li><a href="#">Kebijakan Privasi</a></li>
                <li><a href="#">Panduan Penggunaan</a></li>
            </ul>
        </div>

        {{-- Kontak --}}
        <div class="footer-col">
            <h4>Hubungi Kami</h4>
            <p>SMP Negeri 216 Jakarta</p>
            <p>Jl. Salemba Raya No. 18, RW.4, Kenari,<br>Kec. Senen, Kota Jakarta Pusat,<br>DKI Jakarta 10430</p>
        </div>

    </div>

    {{-- Copyright --}}
    <div class="footer-bottom">
        <div class="max-w-5xl mx-auto px-6 py-6 text-xs text-center text-gray-300">
            © {{ date('Y') }} Layanan Bimbingan Konseling - SMPN 216 Jakarta
        </div>
    </div>
</footer>
    <script>
        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('searchBtn');
            btn.textContent = 'Mencari...';
            setTimeout(() => {
                btn.disabled = true;
            }, 0);
        });
    </script>
</body>
</html>