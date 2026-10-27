<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InterviewQuestion;
use App\Models\InterviewSession;
use App\Models\Resume;
use App\Services\InterviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function __construct(protected InterviewService $interviewService) {}

    /**
     * Start a new interview session
     */
    public function start(Request $request, Resume $resume): JsonResponse
    {
        // Authorization
        if ($resume->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'role_applied' => 'required|string|max:255',
            'mode' => 'sometimes|in:text,voice',
        ]);

        if (!$resume->analysis) {
            return response()->json([
                'message' => 'Resume must be analyzed before starting an interview.',
            ], 400);
        }

        try {
            $session = $this->interviewService->startSession($resume, $request->role_applied, $request->mode ?? 'text');

            $questions = $session->questions->map(fn(InterviewQuestion $q) => [
                'id' => $q->id,
                'question_text' => $q->question_text,
                'type' => $q->question_type,
                'difficulty' => $q->difficulty,
            ])->values();

            return response()->json([
                'interview_session_id' => $session->id,
                'questions' => $questions,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to start interview', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Submit an answer to an interview question
     */
    public function answer(Request $request, InterviewSession $session): JsonResponse
    {
        // Authorization
        $session->load('resume');
        if ($session->resume->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'question_id' => 'required|exists:interview_questions,id',
            'answer_text' => 'required|string',
            'answer_audio' => 'sometimes|string',
            'duration_seconds' => 'sometimes|integer',
        ]);

        $question = InterviewQuestion::findOrFail($request->question_id);
        if ($question->interview_session_id !== $session->id) {
            return response()->json(['message' => 'Question does not belong to this interview session.'], 400);
        }

        // For now, we don't implement audio storage; we pass through the placeholder
        $audioPath = $request->has('answer_audio') ? 'audio/placeholder.mp3' : null;

        try {
            $answer = $this->interviewService->submitAnswer($session, $question, $request->answer_text, $audioPath, $request->duration_seconds ?? null);

            $evaluation = $answer->evaluation_json ?? [];

            return response()->json([
                'evaluation' => [
                    'score' => $answer->score,
                    'strengths' => $evaluation['key_strengths'] ?? [],
                    'weaknesses' => $evaluation['weaknesses'] ?? [],
                    'suggestions' => $evaluation['suggestions'] ?? [],
                ],
                'updated_overall_score' => $session->fresh()->overall_score,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to evaluate answer', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get interview session status
     */
    public function status(InterviewSession $session): JsonResponse
    {
        $session->load('resume');
        if ($session->resume->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $session->load(['questions.answer']);

        return response()->json([
            'session_id' => $session->id,
            'role_applied' => $session->role_applied,
            'started_at' => $session->started_at,
            'completed_at' => $session->completed_at,
            'overall_score' => $session->overall_score,
            'total_questions' => $session->questions->count(),
            'answered_questions' => $session->questions->filter(fn($q) => $q->answer)->count(),
        ]);
    }
}
