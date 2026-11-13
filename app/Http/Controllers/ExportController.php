<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Violation;
use App\Models\StudentKpi;
use App\Models\SchoolClass;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ViolationsExport;
use App\Exports\StudentsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function chooseTahunAjaran()
    {
        $currentYear = now()->month >= 7 ? now()->year : now()->year - 1;
        $currentTahunAjaran = $currentYear . '/' . ($currentYear + 1);

        $tahunAjaranOptions = collect(range(-3, 1))->map(function ($offset) use ($currentYear) {
            $y = $currentYear + $offset;
            return "$y/" . ($y + 1);
        })->values()->all();

        return view('export.choose-tahun-ajaran', compact('tahunAjaranOptions', 'currentTahunAjaran'));
    }

   public function violationsPdf(Request $request)
{
    $query = Violation::with(['student.schoolClass', 'createdBy']);
    $this->applyFilters($query, $request);
    $violations = $query->orderByDesc('violation_date')->get();

    $pdf = Pdf::loadView('pdf.violations-report', [
        'violations' => $violations,
        'date'       => now()->locale('id')->isoFormat('D MMMM Y'),
        'filters'    => $request->all(),
        'signer'     => Auth::user(),
    ])->setPaper('a4', 'landscape');

    return $pdf->download('laporan-pelanggaran-' . now()->format('Ymd') . '.pdf');
}

    public function violationsExcel(Request $request)
    {
        return Excel::download(new ViolationsExport($request->all()), 'laporan-pelanggaran-' . now()->format('Ymd') . '.xlsx');
    }

        public function studentsPdf(Request $request)
    {
        $query = Student::with(['schoolClass', 'kpi'])->active();
        $this->applyStudentFilters($query, $request);
        $students = $query->orderBy('full_name')->get();

        $pdf = Pdf::loadView('pdf.students-report', [
            'students' => $students,
            'date'     => now()->locale('id')->isoFormat('D MMMM Y'),
            'signer'   => Auth::user(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-siswa-' . now()->format('Ymd') . '.pdf');
    }

    public function studentsExcel(Request $request)
    {
        return Excel::download(new StudentsExport($request->all()), 'laporan-siswa-' . now()->format('Ymd') . '.xlsx');
    }

    protected function applyFilters($query, Request $request): void
    {
        if ($request->filled('category'))     $query->where('category', $request->category);
        if ($request->filled('severity'))     $query->where('severity', $request->severity);
        if ($request->filled('date_from'))    $query->where('violation_date', '>=', $request->date_from);
        if ($request->filled('date_to'))      $query->where('violation_date', '<=', $request->date_to);
        if ($request->filled('class_id'))     $query->whereHas('student', fn($q) => $q->where('class_id', $request->class_id));
        if ($request->filled('tahun_ajaran')) $query->where('tahun_ajaran', $request->tahun_ajaran);
    }

    protected function applyStudentFilters($query, Request $request): void
    {
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('nis', 'like', "%{$term}%")
                  ->orWhere('full_name', 'like', "%{$term}%");
            });
        }
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('warning_status')) {
            if ($request->warning_status === 'pembinaan') {
                $query->whereHas('kpi', fn($q) => $q->whereIn('warning_status', ['green', 'yellow']));
            } else {
                $query->whereHas('kpi', fn($q) => $q->where('warning_status', $request->warning_status));
            }
        }
    }
}