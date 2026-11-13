<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; color: #1f2937; padding: 20px; }
    .header-wrapper { border-bottom: 3px solid #000; padding-bottom: 12px; margin-bottom: 16px; }
    .header-wrapper table { border: none; }
    .header-wrapper td { border: none; padding: 0; }
    .gov { font-size: 12px; font-weight: normal; }
    .dept { font-size: 12px; font-weight: normal; }
    .school { font-size: 15px; font-weight: bold; text-transform: uppercase; margin: 2px 0; }
    .address { font-size: 11px; margin-top: 3px; }
    .contact { font-size: 11px; }
    .jakarta { font-size: 11px; margin-top: 4px; font-weight: bold; }
    h2 { font-size: 11px; text-align: center; margin-bottom: 14px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
    table.data-table { width: 100%; border-collapse: collapse; font-size: 8.5px; }
    th { background: #1e3a5f; color: white; padding: 6px 8px; text-align: left; font-weight: bold; }
    td { padding: 5px 8px; border-bottom: 1px solid #e5e7eb; vertical-align: middle; }
    tr:nth-child(even) { background: #f9fafb; }
    .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-weight: bold; font-size: 7.5px; }
    .badge-green  { background: #dcfce7; color: #15803d; }
    .badge-yellow { background: #fef3c7; color: #b45309; }
    .badge-red    { background: #fee2e2; color: #b91c1c; }
    .footer { margin-top: 16px; text-align: right; font-size: 8px; color: #475569; }
    .meta { display: flex; justify-content: space-between; font-size: 8.5px; color: #64748b; margin-bottom: 12px; }
</style>
</head>
<body>

<<div class="header-wrapper">
    <table style="width: 100%; border-collapse: collapse; border: none;">
        <tr>
            <!-- Left Logo -->
            <td style="width: 85px; vertical-align: top;">
                <div class="logo" style="width: 85px; height: 85px;">
                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('logo-jaya-raya.jpg'))) }}" alt="Logo Jaya Raya" style="width: 100%; height: 100%;">
                </div>
            </td>
            <!-- Center Header Text -->
            <td class="header-text" style="text-align: center; vertical-align: top; padding: 0 10px;">
                <div class="gov">PEMERINTAH PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA</div>
                <div class="dept">DINAS PENDIDIKAN</div>
                <div class="school">SEKOLAH MENENGAH PERTAMA NEGERI 216 JAKARTA</div>
                <div class="address">Jalan Salemba Raya No.18, Jakarta Pusat</div>
                <div class="contact">Telepon 31931857 Faksimili 31931857</div>
                <div class="contact">Website: www.smpn216jkt.sch.id Email: smpn216_jp@yahoo.co.id</div>
            </td>
            <!-- Right Spacer (balances the logo width so center text is truly centered) -->
            <td style="width: 85px; vertical-align: top;"></td>
        </tr>
    </table>
</div>

<h2>Laporan Rekapitulasi Skor Perilaku Siswa</h2>
<div class="meta">
    <span>Tanggal Cetak: {{ $date }}</span>
    <span>Total: {{ count($students) }} siswa terdaftar</span>
</div>
<table class="data-table">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 12%;">NIS</th>
            <th style="width: 25%;">Nama Siswa</th>
            <th style="width: 10%;">L/P</th>
            <th style="width: 15%;">Kelas</th>
            <th style="width: 10%; text-align: center;">Skor Perilaku</th>
            <th style="width: 23%;">Status Peringatan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($students as $i => $s)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $s->nis }}</td>
            <td style="font-weight: bold;">{{ $s->full_name }}</td>
            <td>{{ $s->gender }}</td>
            <td>{{ $s->schoolClass?->class_name ?? '-' }}</td>
            <td style="text-align: center; font-weight: bold;">{{ $s->kpi?->overall_score ?? 0 }}</td>
            <td>
                @php
                    $status = $s->kpi?->warning_status ?? 'green';
                    $badgeColor = $status === 'red' ? 'red' : 'yellow';
                @endphp
                <span class="badge badge-{{ $badgeColor }}">
                    {{ $s->kpi?->status_label ?? 'Perlu Pembinaan' }}
                </span>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:16px;color:#475569">Tidak ada data.</td></tr>
        @endforelse
    </tbody>
</table>
<table style="width: 100%; border: none; margin-top: 24px;">
    <tr>
        <td style="width: 55%; border: none;"></td>
        <td style="width: 45%; border: none; text-align: center;">
            <p style="margin-bottom: 2px;">Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p style="font-weight: bold; margin-bottom: 2px;">Guru Bimbingan Konseling</p>
            <div style="height: 60px; display: flex; align-items: center; justify-content: center;">
    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('qrcode.jpeg'))) }}" alt="QR Code" style="width: 55px; height: 55px;">
</div>
            <p style="font-weight: bold; text-decoration: underline; margin-bottom: 2px;">{{ $signer->name ?? 'Guru BK' }}</p>
        <p style="font-size: 7.5px; color: #64748b; font-weight: 500;">NIP. {{ $signer->nip ?? '1028128' }}</p>
        </td>
    </tr>
</table>
</body>
</html>