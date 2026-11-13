# EduGuard-KPI

Sistem monitoring dan evaluasi perilaku siswa berbasis KPI (Key Performance Indicator) untuk Guru Bimbingan dan Konseling (BK).

Setiap pelanggaran yang dicatat mengurangi skor KPI siswa secara otomatis. Saat skor jatuh ke zona kritis, sistem memberi peringatan dini dan membuat draf surat pernyataan dalam bentuk PDF.

## Fitur

- **Dashboard BK**: ringkasan skor KPI sekolah, sebaran siswa per zona (hijau, kuning, merah), dan tren pelanggaran 6 bulan terakhir.
- **Pemantauan kelas dan siswa**: status perilaku per kelas, profil siswa, riwayat pelanggaran, dan grafik perkembangan.
- **Pencatatan pelanggaran**: kategori terstruktur (kehadiran, kedisiplinan, etika sosial, agresivitas, risiko tinggi, integritas) dengan penalti skor otomatis.
- **Peringatan dini**: aktif saat skor di bawah 60, terjadi 3 pelanggaran atau lebih dalam 30 hari, pelanggaran sama berulang 3 kali, atau ada pelanggaran berat dalam 7 hari terakhir.
- **Surat pernyataan digital**: PDF dibuat otomatis, dan scan surat yang sudah ditandatangani bisa diunggah sebagai arsip.
- **Ekspor laporan**: PDF dan Excel dengan filter tanggal, kategori, dan kelas.
- **Portal cek siswa**: halaman publik untuk orang tua melihat status perilaku anak.

## Tech Stack

- Laravel 12 dan Laravel Breeze
- PHP 8.2 atau lebih baru
- MySQL, PostgreSQL, atau SQLite
- Tailwind CSS dan Vite
- barryvdh/laravel-dompdf dan maatwebsite/excel

## Instalasi

```bash
git clone https://github.com/ridaiasyah03/bimbinka216-.git
cd bimbinka216-

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Isi koneksi database di `.env`, lalu jalankan:

```bash
php artisan migrate --seed
php artisan storage:link
composer dev
```

Aplikasi berjalan di `http://localhost:8000`.

## Akun Awal

Seeder membuat akun Guru BK awal beserta data contoh (kelas dan siswa dummy). Lihat `database/seeders/DatabaseSeeder.php` untuk detailnya, dan **ganti password akun tersebut segera** setelah instalasi, terutama bila aplikasi dipasang di server publik.

## Keamanan dan Privasi

- Jangan pernah meng-commit file `.env`, dump database, atau data siswa asli.
- Seluruh data pada repositori ini adalah data contoh (dummy).

## Struktur Penting

| File | Fungsi |
|---|---|
| `app/Services/KpiEngine.php` | Perhitungan penalti dan skor KPI |
| `app/Services/EarlyWarningService.php` | Pengecekan kondisi kritis siswa |
| `app/Services/ViolationService.php` | Alur pencatatan pelanggaran |
| `app/Services/PdfGeneratorService.php` | Pembuatan PDF surat dan laporan |
| `database/seeders/DatabaseSeeder.php` | Data contoh |
