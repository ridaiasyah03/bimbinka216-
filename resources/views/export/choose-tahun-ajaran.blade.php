@extends('layouts.app')
@section('title', 'Export Laporan')
<link rel="icon" type="image/png" href="{{ asset('logo-smpn216.png') }}">
@section('page-title', 'Export Laporan Pelanggaran')
@section('page-subtitle', 'Pilih tahun ajaran untuk laporan yang ingin diunduh')

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
</style>
<div class="max-w-lg mx-auto">
    <div class="glass-card p-8">
        <div class="mb-6">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tahun Ajaran</label>
            <select id="tahunAjaranSelect" class="input-brand w-full bg-white border border-slate-300 text-slate-700 text-sm rounded-xl px-4 py-3">
                <option value="">Semua Tahun Ajaran</option>
                @foreach($tahunAjaranOptions as $ta)
                <option value="{{ $ta }}" {{ $currentTahunAjaran === $ta ? 'selected' : '' }}>{{ $ta }}</option>
                @endforeach
            </select>
            <p class="text-xs text-slate-400 mt-2">Pilih "Semua Tahun Ajaran" untuk mengunduh seluruh data tanpa filter.</p>
        </div>

        <div class="flex gap-3">
            <a id="btnPdf" href="#" class="flex-1 text-center bg-red-500/10 border border-red-500/20 text-red-500 text-sm px-4 py-3 rounded-xl transition-colors font-medium hover:bg-red-500/20">
                📄Unduh PDF
            </a>
            <a id="btnExcel" href="#" class="flex-1 text-center bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 text-sm px-4 py-3 rounded-xl transition-colors font-medium hover:bg-emerald-500/20">
               📄Unduh Excel
            </a>
        </div>
    </div>
</div>

<script>
function buildUrl(base) {
    const ta = document.getElementById('tahunAjaranSelect').value;
    return ta ? `${base}?tahun_ajaran=${encodeURIComponent(ta)}` : base;
}
document.getElementById('btnPdf').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = buildUrl(@json(route('export.violations.pdf')));
});
document.getElementById('btnExcel').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = buildUrl(@json(route('export.violations.excel')));
});
</script>
@endsection