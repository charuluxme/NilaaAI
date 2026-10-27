<?php

namespace App\Console\Commands;

use App\Jobs\ParseResumeJob;
use App\Models\Resume;
use Illuminate\Console\Command;

class ReparseResumesCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'resumentor:reparse-resumes 
                            {--status=* : Filter by status (uploaded, parsed, failed)}
                            {--limit= : Limit the number of resumes to reparse}';

    /**
     * The console command description.
     */
    protected $description = 'Reparse resumes (queues parsing jobs)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $statuses = $this->option('status') ?: ['uploaded', 'parsed'];
        $limit = $this->option('limit');
        
        $query = Resume::whereIn('status', $statuses);
        
        if ($limit) {
            $query->limit((int) $limit);
        }
        
        $resumes = $query->get();
        
        if ($resumes->isEmpty()) {
            $this->info('No resumes found to reparse.');
            return 0;
        }
        
        $this->info("Queuing {$resumes->count()} resume(s) for reparsing...");
        
        $bar = $this->output->createProgressBar($resumes->count());
        $bar->start();
        
        foreach ($resumes as $resume) {
            ParseResumeJob::dispatch($resume);
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('All resumes queued successfully!');
        
        return 0;
    }
}
