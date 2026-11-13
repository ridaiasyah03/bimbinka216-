<?php

namespace App\Console\Commands;

use App\Models\StatementLetter;
use App\Services\PdfGeneratorService;
use Illuminate\Console\Command;

class RegenerateStatementLetters extends Command
{
    protected $signature = 'letters:regenerate';
    protected $description = 'Regenerate semua surat pernyataan yang sudah ada agar pakai tanggal pelanggaran yang benar';

    public function handle(PdfGeneratorService $pdfService)
    {
        $letters = StatementLetter::with('violation')->get();

        $this->info("Ditemukan {$letters->count()} surat untuk digenerate ulang.");

        $bar = $this->output->createProgressBar($letters->count());
        $bar->start();

        $failed = [];

        foreach ($letters as $letter) {
            if (!$letter->violation) {
                $failed[] = $letter->id . ' (violation tidak ditemukan)';
                $bar->advance();
                continue;
            }

            try {
                $pdfService->generateStatementLetter($letter->violation);
            } catch (\Throwable $e) {
                $failed[] = $letter->id . ' — ' . $e->getMessage();
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if (count($failed) > 0) {
            $this->warn('Gagal regenerate untuk:');
            foreach ($failed as $f) {
                $this->line(' - ' . $f);
            }
        }

        $this->info('Selesai regenerate surat pernyataan.');
    }
}