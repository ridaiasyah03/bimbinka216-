<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Login — Guru BK</title>
        <link rel="icon" type="image/png" href="{{ asset('logo-smpn216.png') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,600;8..60,700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root {
                --navy: #16324B;
                --blue: #4E8FC4;
                --blue-soft: #DCEBF6;
                --line: #D8E6F0;
            }
            .serif { font-family: 'Source Serif 4', Georgia, serif; }

            .login-photo-panel {
    position: relative;
    background-image: url('{{ asset("gedung_216.jpeg") }}');
    background-repeat: no-repeat;
    background-position: 50% 5%;    
    background-size: 173%;
}
            .login-photo-panel::before {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(22,50,75,0.55) 0%, rgba(22,50,75,0.85) 100%);
            }
            .login-photo-panel::after {
                content: "";
                position: absolute;
                right: 0; top: 0; bottom: 0;
                width: 4px;
                background: linear-gradient(180deg, #16324B 0%, #4E8FC4 60%, #4C7A52 100%);
            }
            .btn-search {
                background: linear-gradient(90deg, #16324B 0%, #4E8FC4 100%);
                box-shadow: 0 15px 30px rgba(22,50,75,0.25);
                transition: background .2s ease;
}
            .btn-search:hover {
                background: linear-gradient(90deg, #0F2436 0%, #3D7AAB 100%);
            }

            .access-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: var(--blue-soft);
                color: var(--navy);
                border: 1px solid var(--line);
                border-radius: 999px;
                padding: 5px 12px;
                font-size: 11px;
                font-weight: 600;
                letter-spacing: .3px;
                text-transform: uppercase;
            }
            .access-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: #4C7A52; }

            .security-note {
                display: flex;
                align-items: flex-start;
                gap: 8px;
                font-size: 12px;
                line-height: 1.6;
                color: #5B7186;
            }

            /* Chip kaca untuk brand di panel foto — supaya tidak terasa "teks nempel" polos */
            .login-brand-chip {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                background: rgba(255,255,255,0.10);
                border: 1px solid rgba(255,255,255,0.28);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                padding: 9px 20px 9px 9px;
                border-radius: 18px;
                box-shadow: 0 12px 28px rgba(0,0,0,0.28);
                animation: fadeInBrand .6s ease-out;
            }
            @keyframes fadeInBrand {
                from { opacity: 0; transform: translateY(-8px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .login-brand-logo {
                width: 40px;
                height: 40px;
                border-radius: 12px;
                background: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                flex-shrink: 0;
                box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            }
            .login-brand-title {
                font-weight: 700;
                font-size: 13.5px;
                letter-spacing: .04em;
                color: #fff;
                display: block;
                text-shadow: 0 1px 6px rgba(0,0,0,0.3);
            }
            .login-brand-subtitle {
                font-size: 10px;
                font-weight: 600;
                letter-spacing: .12em;
                text-transform: uppercase;
                color: #CFE1EF;
                display: block;
                margin-top: 3px;
            }
        </style>
    </head>
    <body class="font-sans text-slate-800 antialiased bg-slate-50 min-h-screen overflow-x-hidden">

        <div class="min-h-screen grid lg:grid-cols-2">

            {{-- Panel kiri: foto gedung + identitas sekolah --}}
            <div class="login-photo-panel hidden lg:flex flex-col justify-between p-12 text-white">
                <a href="/" class="relative z-10 login-brand-chip">
                    <div class="login-brand-logo">
                        <img src="{{ asset('logo-smpn216.png') }}" alt="Logo SMPN 216 Jakarta" class="w-full h-full object-contain p-1">
                    </div>
                    <div>
                        <span class="login-brand-title">SMPN 216 JAKARTA</span>
                        <span class="login-brand-subtitle">Dashboard Monitoring Pelanggaran Siswa</span>
                    </div>
                </a>

                <div class="relative z-10">
                    <h2 class="serif font-semibold text-3xl leading-snug mb-3">
                        Bimbingan &amp; Konseling<br>yang Lebih Terarah
                    </h2>
                    <p class="text-sm text-blue-50 max-w-sm leading-relaxed">
                        Pantau pelanggaran, skor pelanggaran, dan tindak lanjut siswa dalam satu dashboard yang rapi dan real-time.
                    </p>
                </div>
            </div>

            {{-- Panel kanan: form login --}}
            <div class="flex flex-col justify-center items-center px-6 py-12 relative">
                <div class="w-full max-w-md">

                    {{-- Logo untuk mobile (panel kiri disembunyikan di layar kecil) --}}
                    <a href="/" class="lg:hidden flex items-center gap-3 mb-8">
                        <div class="w-11 h-11 rounded-xl bg-white flex items-center justify-center shadow-lg border border-slate-200 overflow-hidden">
                            <img src="{{ asset('logo-smpn216.png') }}" alt="Logo SMPN 216 Jakarta" class="w-full h-full object-contain p-1">
                        </div>
                        <div>
                            <span class="font-extrabold text-slate-800 text-lg tracking-tight block">Pelanggaran Siswa</span>
                            <span class="text-xs text-indigo-400 font-semibold uppercase block">Dashboard Monitoring</span>
                        </div>
                    </a>

                    <span class="access-badge mb-5"><span class="dot"></span> Akses Khusus Guru BK</span>

                    <h1 class="serif font-semibold text-2xl text-slate-800 mb-1">Selamat Datang </h1>
                    <p class="text-sm text-slate-500 mb-8 leading-relaxed">
                        Masuk Untuk Mengakses Dashboard Monitoring Pelanggaran dan Skor Perilaku Siswa.
                    </p>

                    <div class="bg-white border border-slate-200 shadow-xl rounded-2xl px-8 py-8">
                        {{ $slot }}
                    </div>

                    <div class="security-note mt-6">
                        <svg width="15" height="15" class="mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L3 6v6c0 5 3.8 8.7 9 10 5.2-1.3 9-5 9-10V6l-9-4z" stroke="#4E8FC4" stroke-width="1.6" stroke-linejoin="round"/>
                        </svg>
                        <span>Halaman ini khusus untuk Guru Bimbingan &amp; Konseling. Data siswa yang ditampilkan bersifat rahasia.</span>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>