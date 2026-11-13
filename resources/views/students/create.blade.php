@extends('layouts.app')
@section('title', 'Tambah Siswa')
<link rel="icon" type="image/png" href="{{ asset('logo-smpn216.png') }}">
@section('page-title', 'Tambah Siswa Baru')
@section('page-subtitle', 'Daftarkan siswa baru ke sistem')

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
    .btn-save {
        background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 100%);
        box-shadow: 0 12px 24px rgba(22,50,75,0.22);
        transition: background .2s ease;
    }
    .btn-save:hover {
        background: linear-gradient(90deg, var(--navy-dark) 0%, var(--blue-dark) 100%);
    }
</style>
<div class="max-w-2xl mx-auto">
    <div class="glass-card p-8">
        <form method="POST" action="{{ route('students.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">NIS *</label>
                <input type="text" name="nis" value="{{ old('nis') }}" required
                       class="input-brand w-full bg-white border border-slate-300 text-slate-800 text-sm rounded-xl px-4 py-3 placeholder-slate-400"
                       placeholder="19000">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap *</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" required
                       class="input-brand w-full bg-white border border-slate-300 text-slate-800 text-sm rounded-xl px-4 py-3 placeholder-slate-400"
                       placeholder="Nama lengkap siswa">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Jenis Kelamin *</label>
                    <select name="gender" required class="input-brand w-full bg-white border border-slate-300 text-slate-700 text-sm rounded-xl px-4 py-3">
                        <option value="">Pilih</option>
                        <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kelas *</label>
                    <select name="class_id" required class="input-brand w-full bg-white border border-slate-300 text-slate-700 text-sm rounded-xl px-4 py-3">
                        <option value="">Pilih Kelas</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->class_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                    <select name="status" class="input-brand w-full bg-white border border-slate-300 text-slate-700 text-sm rounded-xl px-4 py-3">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                        <option value="graduated">Lulus</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tahun Ajaran *</label>
        <select name="tahun_ajaran" required class="input-brand w-full bg-white border border-slate-300 text-slate-700 text-sm rounded-xl px-4 py-3">
            @foreach($tahunAjaranOptions as $ta)
            <option value="{{ $ta }}" {{ old('tahun_ajaran', $currentTahunAjaran) === $ta ? 'selected' : '' }}>{{ $ta }}</option>
            @endforeach
        </select>
    </div>
</div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tempat Lahir</label>
                    <input type="text" name="birth_place" value="{{ old('birth_place') }}"
                           class="input-brand w-full bg-white border border-slate-300 text-slate-800 text-sm rounded-xl px-4 py-3 placeholder-slate-400"
                           placeholder="Jakarta">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                           class="input-brand w-full bg-white border border-slate-300 text-slate-800 text-sm rounded-xl px-4 py-3">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Orang Tua / Wali</label>
                <input type="text" name="parent_name" value="{{ old('parent_name') }}"
                       class="input-brand w-full bg-white border border-slate-300 text-slate-800 text-sm rounded-xl px-4 py-3 placeholder-slate-400"
                       placeholder="Nama ayah/ibu/wali">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Alamat</label>
                <textarea name="address" rows="2"
                          class="input-brand w-full bg-white border border-slate-300 text-slate-800 text-sm rounded-xl px-4 py-3 placeholder-slate-400 resize-none"
                          placeholder="Alamat lengkap siswa">{{ old('address') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-save flex-1 text-white font-semibold py-3 rounded-xl transition-all">
                    Simpan Siswa
                </button>
                <a href="{{ route('students.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors text-sm font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection