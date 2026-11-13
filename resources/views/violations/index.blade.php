@extends('layouts.app')
@section('title', 'Daftar Pelanggaran')
<link rel="icon" type="image/png" href="{{ asset('logo-smpn216.png') }}">
@section('page-title', 'Daftar Pelanggaran')
@section('page-subtitle', 'Riwayat seluruh pelanggaran siswa')

@php
    $backUrl = null;
    if (request()->hasAny(['category', 'severity', 'class_id', 'student_id', 'date_from', 'date_to'])) {
        if (request()->filled('class_id')) {
            $backUrl = route('classes.show', request('class_id'));
        } else {
            $backUrl = route('dashboard');
        }
    }
@endphp

@if($backUrl)
    @section('back-url', $backUrl)
@endif

@section('content')
<style>
    .input-brand {
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .input-brand:focus {
        outline: none;
        border-color: var(--blue) !important;
        box-shadow: 0 0 0 3px rgba(78,143,196,0.2);
    }
    .btn-filter {
        background: var(--navy);
        transition: background .15s ease;
    }
    .btn-filter:hover { background: var(--navy-dark); }
    .btn-add {
        background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 100%);
        transition: background .2s ease;
    }
    .btn-add:hover {
        background: linear-gradient(90deg, var(--navy-dark) 0%, var(--blue-dark) 100%);
    }
    .link-detail { color: var(--blue-dark); }
    .link-detail:hover { background: rgba(78,143,196,0.1); }
    .avatar-brand {
        background: rgba(78,143,196,0.2);
        color: var(--blue-dark);
    }
</style>

{{-- Filter Bar --}}
<div class="glass-card p-4 mb-6 flex flex-col sm:flex-row sm:items-start gap-3">
    <form method="GET" action="{{ route('violations.index') }}" class="flex flex-wrap gap-3 flex-1">
        <select name="category" class="input-brand bg-white border border-slate-300 text-slate-700 text-sm rounded-xl px-3 py-2.5">
            <option value="">Semua Kategori</option>
            @foreach(['kehadiran'=>'Kehadiran','kedisiplinan'=>'Kedisiplinan','etika_sosial'=>'Etika Sosial','agresivitas'=>'Agresivitas','integritas'=>'Integritas','risiko_tinggi'=>'Risiko Tinggi'] as $key=>$label)
            <option value="{{ $key }}" {{ request('category')===$key?'selected':'' }}>{{ $label }}</option>
            @endforeach
        </select>

        <select name="severity" class="input-brand bg-white border border-slate-300 text-slate-700 text-sm rounded-xl px-3 py-2.5">
            <option value="">Semua Keparahan</option>
            <option value="ringan" {{ request('severity')==='ringan'?'selected':'' }}>🟡 Ringan</option>
            <option value="sedang" {{ request('severity')==='sedang'?'selected':'' }}>🟠 Sedang</option>
            <option value="berat"  {{ request('severity')==='berat' ?'selected':'' }}>🔴 Berat</option>
        </select>

        <select name="class_id" class="input-brand bg-white border border-slate-300 text-slate-700 text-sm rounded-xl px-3 py-2.5">
            <option value="">Semua Kelas</option>
            @foreach($classes as $class)
            <option value="{{ $class->id }}" {{ request('class_id')==$class->id?'selected':'' }}>{{ $class->class_name }}</option>
            @endforeach
        </select>

        <input type="date" name="date_from" value="{{ request('date_from') }}"
               class="input-brand bg-white border border-slate-300 text-slate-700 text-sm rounded-xl px-4 py-2.5">
        <input type="date" name="date_to" value="{{ request('date_to') }}"
               class="input-brand bg-white border border-slate-300 text-slate-700 text-sm rounded-xl px-4 py-2.5">

        <button type="submit" class="btn-filter text-white text-sm px-5 py-2.5 rounded-xl transition-colors font-medium">Filter</button>
        <a href="{{ route('violations.index') }}" class="text-gray-500 hover:text-slate-800 text-sm px-3 py-2.5 rounded-xl transition-colors">Reset</a>
    </form>
    <div class="flex gap-2">
        <a href="{{ route('export.violations.pdf') }}?{{ http_build_query(request()->all()) }}"
           class="bg-red-500/10 border border-red-500/20 text-red-400 text-sm px-4 py-2.5 rounded-xl transition-colors font-medium flex items-center gap-1.5 hover:bg-red-500/20" title="Export PDF">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            <span>PDF</span>
        </a>
        <a href="{{ route('export.violations.excel') }}?{{ http_build_query(request()->all()) }}"
           class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm px-4 py-2.5 rounded-xl transition-colors font-medium flex items-center gap-1.5 hover:bg-emerald-500/20" title="Export Excel">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>Excel</span>
        </a>
        <a href="{{ route('violations.create') }}" class="btn-add text-white text-sm px-5 py-2.5 rounded-xl transition-all font-medium flex items-center gap-2 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pelanggaran
        </a>
    </div>
</div>

{{-- Violations Table --}}
<div class="glass-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-100/50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Siswa</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Sub Kategori</th>
                    <th class="px-4 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Severity</th>
                    <th class="px-4 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Surat</th>
                    <th class="px-4 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/50">
                @forelse($violations as $v)
                <tr class="hover:bg-slate-100/30 transition-colors group">
                    <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">{{ $v->violation_date->format('d/m/Y') }}</td>
                    <td class="px-4 py-4">
                        <a href="{{ route('students.show', $v->student) }}" class="flex items-center gap-3 group">
                            <div class="w-9 h-9 rounded-full avatar-brand flex items-center justify-center text-sm font-bold flex-shrink-0">
                                {{ substr($v->student?->full_name ?? '?', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-medium text-slate-700 group-hover:text-slate-900 transition-colors">{{ $v->student?->full_name }}</p>
                                <p class="text-xs text-slate-400">{{ $v->student?->schoolClass?->class_name }}</p>
                            </div>
                        </a>
                    </td>
                    <td class="px-4 py-4 text-slate-600">{{ $v->category_label }}</td>
                    <td class="px-4 py-4 text-slate-500 text-xs">{{ $v->sub_category_label }}</td>
                    <td class="px-4 py-4 text-center">
                        <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full
                            {{ $v->severity === 'berat' ? 'bg-red-500/15 text-red-400 border border-red-500/30' : ($v->severity === 'sedang' ? 'bg-amber-500/15 text-amber-400 border border-amber-500/30' : 'bg-yellow-500/15 text-yellow-400 border border-yellow-500/30') }}">
                            {{ $v->severity_label }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        @if($v->statementLetter?->generated_pdf)
                        <a href="{{ asset('storage/' . $v->statementLetter->generated_pdf) }}" target="_blank"
                           class="text-xs link-detail hover:underline">📄 Unduh</a>
                        @else
                        <span class="text-xs text-slate-300">–</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('violations.show', $v) }}" class="link-detail text-xs px-2 py-1 rounded-lg transition-colors">Detail</a>
                            <form action="{{ route('violations.destroy', $v->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pelanggaran ini? KPI akan otomatis dihitung ulang.');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:text-red-400 px-2 py-1 rounded-lg hover:bg-red-500/10 transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Belum ada data pelanggaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($violations->hasPages())
    <div class="px-6 py-2 border-t border-slate-200">
        {{ $violations->links() }}
    </div>
    @endif
</div>
@endsection