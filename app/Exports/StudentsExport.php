<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Student::with(['schoolClass', 'kpi'])->active();

        if (!empty($this->filters['search'])) {
            $term = $this->filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('nis', 'like', "%{$term}%")
                  ->orWhere('full_name', 'like', "%{$term}%");
            });
        }

        if (!empty($this->filters['class_id'])) {
            $query->where('class_id', $this->filters['class_id']);
        }

        if (!empty($this->filters['warning_status'])) {
            if ($this->filters['warning_status'] === 'pembinaan') {
                $query->whereHas('kpi', fn($q) => $q->whereIn('warning_status', ['green', 'yellow']));
            } else {
                $query->whereHas('kpi', fn($q) => $q->where('warning_status', $this->filters['warning_status']));
            }
        }

        return $query->orderBy('full_name')->get();
    }

    public function headings(): array
    {
        return [
            ['LAPORAN MONITORING PELANGGARAN SISWA SMPN 216 JAKARTA'],
            ['Sistem Monitoring Perilaku dan Pelanggaran Siswa'],
            [],
            ['No','NIS','Nama Lengkap','L/P','Kelas','Skor Keseluruhan','Status','Kehadiran','Disiplin','Etika Sosial','Agresivitas','Integritas','Risiko Tinggi']
        ];
    }

    public function map($student): array
    {
        static $i = 0;
        $i++;
        $kpi = $student->kpi;
        return [
            $i,
            $student->nis,
            $student->full_name,
            $student->gender === 'L' ? 'Laki-laki' : 'Perempuan',
            $student->schoolClass?->class_name,
            $kpi?->overall_score ?? 0,
            $kpi?->status_label ?? 'Perlu Pembinaan',
            $kpi?->attendance_score ?? 0,
            $kpi?->discipline_score ?? 0,
            $kpi?->social_ethics_score ?? 0,
            $kpi?->aggression_score ?? 0,
            $kpi?->integrity_score ?? 0,
            $kpi?->high_risk_score ?? 0,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
            4 => ['font' => ['bold' => true]],
        ];
    }
}