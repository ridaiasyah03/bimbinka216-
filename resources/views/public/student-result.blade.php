<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $student->full_name }} — Dashboard Pelanggaran Siswa</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-smpn216.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.2/dist/apexcharts.min.js" defer></script>
    <style>
        :root {
            --navy: #16324B;
            --navy-dark: #0F2436;
            --blue: #4E8FC4;
            --blue-dark: #3D7AAB;
            --blue-soft: #DCEBF6;
        }
        body { font-family: 'Inter', sans-serif; }
        .fade-in { animation: fadeIn .5s ease-out; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }

        .brand-title { font-weight: 700; color: var(--navy); font-size: 13.5px; }
        @media (max-width: 480px) { .brand-title { font-size: 12px; } }

        .link-back {
            color: var(--blue-dark);
            border: 1px solid rgba(78,143,196,0.35);
            transition: color .15s ease, border-color .15s ease, background .15s ease;
            white-space: nowrap;
        }
        .link-back:hover { color: #fff; background: var(--blue-dark); border-color: var(--blue-dark); }

        .hero-card {
            background: linear-gradient(135deg, #EAF3FA 0%, #F5F9FB 100%);
            border: 1px solid #E1EBF2;
        }
        .avatar-badge {
            background: linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%);
            box-shadow: 0 15px 30px rgba(22,50,75,0.28);
        }
        .tag-blue {
            background: rgba(78,143,196,0.12);
            color: var(--blue-dark);
            border: 1px solid rgba(78,143,196,0.25);
        }
        .rec-arrow { color: var(--blue); }

        /* Hero card layout: avatar+score together on mobile, avatar/info/score in a row on desktop.
           Plain media query (not Tailwind sm: utilities) so ordering is guaranteed regardless of build/purge. */
        .hero-flex {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            gap: 16px;
        }
        .hero-avatar { order: 1; }
        .hero-score { order: 2; margin-left: auto; }
        .hero-info { order: 3; width: 100%; }
        @media (min-width: 640px) {
            .hero-flex { flex-wrap: nowrap; align-items: center; gap: 24px; }
            .hero-score { order: 3; margin-left: 0; }
            .hero-info { order: 2; width: auto; flex: 1 1 0%; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">

<header class="border-b border-slate-200 bg-white/80 backdrop-blur sticky top-0 z-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between gap-3">
        <div class="flex items-center gap-2.5 min-w-0">
            <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                <img src="{{ asset('logo-smpn216.png') }}" alt="Logo SMPN 216 Jakarta" class="w-full h-full object-contain p-0.5">
            </div>
            <span class="brand-title truncate">Dashboard Pelanggaran Siswa</span>
        </div>
        <a href="{{ route('public.lookup') }}" class="link-back text-xs font-semibold px-3 py-1.5 rounded-lg flex-shrink-0">← Cari Lagi</a>
    </div>
</header>

@php
    $score  = $student->kpi?->overall_score ?? 0;
    $status = $student->kpi?->warning_status ?? 'green';
    $colorClass = $status === 'red' ? 'red' : 'amber';
    $statusLabel = $status === 'red' ? 'Risiko Tinggi' : 'Perlu Pembinaan';
@endphp

<main class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8 fade-in">

    {{-- Profile Hero --}}
    <div class="hero-card rounded-3xl p-5 sm:p-8 mb-6 relative overflow-hidden">
        <div class="relative flex flex-wrap sm:flex-nowrap items-start sm:items-center gap-4 sm:gap-6 hero-flex">

            {{-- Avatar --}}
            <div class="relative hero-avatar">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl avatar-badge flex items-center justify-center text-2xl sm:text-3xl font-black text-white">
                    {{ substr($student->full_name, 0, 1) }}
                </div>
                <span class="absolute -bottom-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 rounded-full border-2 border-slate-100
                    {{ $status === 'red' ? 'bg-red-500' : 'bg-amber-500' }}"></span>
            </div>

            {{-- Score ring: sits beside avatar on mobile, at the end on desktop --}}
            <div class="text-center hero-score">
                <div class="relative w-20 h-20 sm:w-24 sm:h-24">
                    <svg class="w-20 h-20 sm:w-24 sm:h-24 -rotate-90" viewBox="0 0 36 36">
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e2e8f0" stroke-width="3.5"/>
                        <circle cx="18" cy="18" r="15.9" fill="none"
                             stroke="{{ $status === 'green' ? '#10b981' : ($status === 'yellow' ? '#f59e0b' : '#ef4444') }}"
                             stroke-width="3.5" stroke-dasharray="{{ $score }},100" stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-lg sm:text-xl font-black text-slate-800">{{ $score }}</span>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-1">Overall Score</p>
            </div>

            {{-- Name & meta: full width, wraps below on mobile --}}
            <div class="hero-info">
                <h1 class="text-xl sm:text-2xl font-black text-slate-800">{{ $student->full_name }}</h1>
                <p class="text-slate-500 mt-1 text-sm">{{ $student->schoolClass?->class_name }} · NIS: {{ $student->nis }}</p>
                <div class="flex flex-wrap gap-2 mt-3">
                    <span class="text-xs px-3 py-1 rounded-full font-semibold border
                        {{ $status === 'red' ? 'bg-red-500/20 text-red-600 border-red-500/30' : 'bg-amber-500/20 text-amber-600 border-amber-500/30' }}">
                        {{ $statusLabel }}
                    </span>
                    <span class="text-xs px-3 py-1 rounded-full bg-white/80 text-slate-600 border border-slate-200">{{ $student->gender_label }}</span>
                    @if($student->parent_name)
                    <span class="text-xs px-3 py-1 rounded-full bg-white/80 text-slate-600 border border-slate-200">Wali: {{ $student->parent_name }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- LEFT --}}
        <div class="space-y-6">
            {{-- KPI Dimensions --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6">
               <h3 class="flex items-start gap-2 text-sm font-bold text-slate-800 mb-4">
            <span class="text-base leading-none shrink-0">📊</span>
            <span>Skor Pelanggaran Siswa per Dimensi</span>
        </h3>
                @php
                    $dims = [
                        ['Kehadiran','🕐',$student->violations->where('category', 'kehadiran')->isEmpty() ? 0 : ($student->kpi?->attendance_score ?? 0)],
                        ['Kedisiplinan','📋',$student->violations->where('category', 'kedisiplinan')->isEmpty() ? 0 : ($student->kpi?->discipline_score ?? 0)],
                        ['Etika Sosial','🤝',$student->violations->where('category', 'etika_sosial')->isEmpty() ? 0 : ($student->kpi?->social_ethics_score ?? 0)],
                        ['Agresivitas','💢',$student->violations->where('category', 'agresivitas')->isEmpty() ? 0 : ($student->kpi?->aggression_score ?? 0)],
                        ['Integritas','⚖️',$student->violations->where('category', 'integritas')->isEmpty() ? 0 : ($student->kpi?->integrity_score ?? 0)],
                        ['Risiko tinggi','🚨',$student->violations->where('category', 'risiko_tinggi')->isEmpty() ? 0 : ($student->kpi?->high_risk_score ?? 0)],
                        ['Tren Perilaku','📈',$student->kpi?->behavior_trend_score ?? 0],
                    ];
                @endphp
                <div class="space-y-3">
                    @foreach($dims as [$name,$icon,$val])
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-500">{{ $icon }} {{ $name }}</span>
                            <span class="font-bold {{ $val <= 20 ? 'text-emerald-500' : ($val <= 40 ? 'text-amber-500' : 'text-red-500') }}">{{ round($val) }}/100</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full {{ $val <= 20 ? 'bg-emerald-500' : ($val <= 40 ? 'bg-amber-500' : 'bg-red-500') }}" style="width:{{ $val }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Recommendations --}}
            @if(count($recommendations) > 0)
            <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6">
                <h3 class="text-sm font-bold text-slate-800 mb-3">💡 Rekomendasi</h3>
                <ul class="space-y-2">
                    @foreach($recommendations as $rec)
                    <li class="flex items-start gap-2 text-xs text-slate-600">
                        <span class="rec-arrow mt-0.5 flex-shrink-0">→</span>{{ $rec }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        {{-- RIGHT --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Trend Chart --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6">
                <h3 class="text-sm font-bold text-slate-800 mb-4">📈 Tren Pelanggaran Bulanan</h3>
                <div id="chartTrend" class="h-48"></div>
            </div>

            {{-- Violations --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-800">📜 Riwayat Pelanggaran</h3>
                    <span class="text-xs text-slate-400">{{ $student->violations->count() }} catatan</span>
                </div>
                <div class="space-y-4 max-h-80 overflow-y-auto pr-1">
                    @forelse($student->violations->sortByDesc('violation_date') as $v)
                    <div class="relative pl-5 border-l-2 {{ $v->severity === 'berat' ? 'border-red-500' : ($v->severity === 'sedang' ? 'border-amber-500' : 'border-slate-300') }}">
                        <div class="absolute -left-1.5 top-1 w-3 h-3 rounded-full {{ $v->severity === 'berat' ? 'bg-red-500' : ($v->severity === 'sedang' ? 'bg-amber-500' : 'bg-gray-600') }}"></div>
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-xs font-semibold text-slate-700">{{ $v->category_label }}</span>
                                    <span class="text-xs px-2 py-0.5 rounded-full {{ $v->severity === 'berat' ? 'bg-red-500/20 text-red-500' : ($v->severity === 'sedang' ? 'bg-amber-500/20 text-amber-500' : 'bg-slate-200 text-slate-500') }}">{{ $v->severity_label }}</span>
                                    @if($v->tahun_ajaran)
                                    <span class="text-xs px-2 py-0.5 rounded-full tag-blue">📅 {{ $v->tahun_ajaran }}</span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-500 mt-1">{{ $v->sub_category_label }} — {{ $v->description }}</p>
                            </div>
                            <span class="text-xs text-slate-400 whitespace-nowrap">{{ $v->violation_date->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <p class="text-4xl mb-2">🎉</p>
                        <p class="text-sm text-slate-400">Tidak ada catatan pelanggaran.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="border-t border-slate-200 py-4 text-center text-xs text-slate-400 mt-8">
    Dashboard Pelanggaran Siswa — Data diperbarui otomatis setiap ada perubahan
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new ApexCharts(document.getElementById('chartTrend'), {
        chart: { background:'transparent', toolbar:{show:false}, fontFamily:'Inter', type:'line', height:190 },
        theme: { mode:'light' },
        series: [{ name:'Pelanggaran', data: @json($counts) }],
        xaxis: { categories: @json($months), labels:{style:{colors:'#64748b',fontSize:'11px'}} },
        yaxis: { labels:{style:{colors:'#64748b'}}, min:0, forceNiceScale:true },
        stroke: { curve: 'smooth', width: 3 },
        colors: ['#4E8FC4'],
        grid: { borderColor:'#e2e8f0' },
        tooltip: { theme:'light' },
    }).render();
});
</script>
</body>
</html>