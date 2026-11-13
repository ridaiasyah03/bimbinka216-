<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Services\KpiEngine;
use Illuminate\Console\Command;

class RecalculateAllKpi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kpi:recalculate-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hitung ulang KPI (semua dimensi) untuk seluruh siswa berdasarkan data pelanggaran yang tersimpan.';

    public function handle(KpiEngine $kpiEngine): int
    {
        $students = Student::all();
        $total    = $students->count();

        if ($total === 0) {
            $this->warn('Tidak ada data siswa ditemukan.');
            return self::SUCCESS;
        }

        $this->info("Menghitung ulang KPI untuk {$total} siswa...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $errors = [];

        foreach ($students as $student) {
            try {
                $kpiEngine->recalculate($student);
            } catch (\Throwable $e) {
                $errors[] = "Siswa #{$student->id} ({$student->full_name}): {$e->getMessage()}";
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if (count($errors) > 0) {
            $this->error(count($errors) . ' siswa gagal dihitung ulang:');
            foreach ($errors as $err) {
                $this->line(" - {$err}");
            }
        }

        $this->info('Selesai! ' . ($total - count($errors)) . " dari {$total} siswa berhasil di-recalculate.");

        return self::SUCCESS;
    }
}