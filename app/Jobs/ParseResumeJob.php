<?php

namespace App\Jobs;

use App\Events\ResumeParsed;
use App\Events\ResumeParsingFailed;
use App\Models\Resume;
use App\Services\AnalysisService;
use App\Services\ResumeParserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ParseResumeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Resume $resume
    ) {}

    /**
     * Execute the job.
     */
    public function handle(
        ResumeParserService $parser,
        AnalysisService $analyzer
    ): void
    {
        try {
            Log::info('Starting resume parsing', ['resume_id' => $this->resume->id]);
            
            // Get full file path
            $fullPath = Storage::path($this->resume->file_path);
            
            if (!file_exists($fullPath)) {
                throw new \Exception("Resume file not found: {$fullPath}");
            }
            
            // Parse resume
            $parsedData = $parser->parse($fullPath, $this->resume->mime_type);
            
            // Analyze resume
            $analyzer->analyze($this->resume, $parsedData);
            
            // Update resume status
            $this->resume->update(['status' => 'parsed']);
            
            // Dispatch success event
            ResumeParsed::dispatch($this->resume);
            
            Log::info('Resume parsed successfully', ['resume_id' => $this->resume->id]);
            
        } catch (\Exception $e) {
            Log::error('Resume parsing failed', [
                'resume_id' => $this->resume->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Update resume status
            $this->resume->update(['status' => 'failed']);
            
            // Dispatch failure event
            ResumeParsingFailed::dispatch($this->resume, $e->getMessage());
            
            throw $e;
        }
    }
}
