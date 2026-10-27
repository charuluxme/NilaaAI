<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadResumeRequest;
use App\Jobs\ParseResumeJob;
use App\Models\Resume;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    /**
     * Upload a new resume
     */
    public function upload(UploadResumeRequest $request): JsonResponse
    {
        $file = $request->file('file');
        $user = auth()->user();
        
        // Generate unique filename
        $timestamp = now()->timestamp;
        $random = bin2hex(random_bytes(8));
        $extension = $file->getClientOriginalExtension();
        $filename = "{$timestamp}-{$random}.{$extension}";
        
        // Store file
        $path = $file->storeAs(
            "resumes/{$user->id}",
            $filename,
            'local'
        );
        
        // Create resume record
        $resume = Resume::create([
            'user_id' => $user->id,
            'file_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size_bytes' => $file->getSize(),
            'uploaded_at' => now(),
            'status' => 'uploaded',
        ]);
        
        // Dispatch parsing job
        ParseResumeJob::dispatch($resume);
        
        return response()->json([
            'resume_id' => $resume->id,
            'status' => $resume->status,
            'message' => 'Resume uploaded successfully. Parsing in progress.',
        ], 201);
    }

    /**
     * Get resume analysis
     */
    public function analysis(Resume $resume): JsonResponse
    {
        // Check authorization
        if ($resume->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $resume->load(['analysis', 'skillTags']);
        
        if (!$resume->analysis) {
            return response()->json([
                'message' => 'Analysis not available yet. Resume is still being processed.',
            ], 202);
        }
        
        return response()->json([
            'resume' => [
                'id' => $resume->id,
                'user_id' => $resume->user_id,
                'original_filename' => $resume->original_filename,
                'status' => $resume->status,
                'uploaded_at' => $resume->uploaded_at,
            ],
            'analysis' => [
                'extracted_text' => $resume->analysis->extracted_text,
                'skills' => $resume->analysis->skills_json,
                'ats_score' => $resume->analysis->ats_score,
                'readability_score' => $resume->analysis->readability_score,
                // suggestions is cast to array on the model, return directly
                'suggestions' => $resume->analysis->suggestions,
                // return an array of canonical names
                'skill_tags' => $resume->skillTags->map(fn($tag) => $tag->canonical_name)->values()->all(),
            ],
        ]);
    }

    /**
     * Re-dispatch parsing for a resume (manual reanalyze)
     */
    public function reanalyze(Request $request, Resume $resume): JsonResponse
    {
        if ($resume->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Mark as queued and dispatch job
        $resume->update(['status' => 'uploaded']);
        ParseResumeJob::dispatch($resume);

        return response()->json(['message' => 'Reanalysis dispatched', 'resume_id' => $resume->id], 202);
    }
}
