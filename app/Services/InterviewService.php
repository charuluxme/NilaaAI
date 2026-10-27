<?php

namespace App\Services;

use App\Models\InterviewAnswer;
use App\Models\InterviewQuestion;
use App\Models\InterviewSession;
use App\Models\Resume;
use Illuminate\Support\Facades\Log;

/**
 * InterviewService - Orchestrates interview sessions: question generation, answer evaluation, scoring
 */
class InterviewService
{
    public function __construct(protected OpenAIService $openAI) {}

    /**
     * Start a new interview session and generate questions
     */
    public function startSession(Resume $resume, string $roleApplied, string $mode = 'text'): InterviewSession
    {
        $resume->load('analysis');

        $session = InterviewSession::create([
            'resume_id' => $resume->id,
            'role_applied' => $roleApplied,
            'started_at' => now(),
            'session_metadata' => ['mode' => $mode],
        ]);

        // Generate questions using OpenAI
        $questionsData = $this->openAI->generateInterviewQuestions(
            $resume->analysis->extracted_text,
            $roleApplied
        );

        foreach ($questionsData as $qData) {
            InterviewQuestion::create([
                'interview_session_id' => $session->id,
                'question_text' => $qData['question_text'] ?? $qData['question'] ?? '',
                'question_type' => $qData['type'] ?? 'technical',
                'difficulty' => $qData['difficulty'] ?? 3,
            ]);
        }

        Log::info('Interview session started', ['session_id' => $session->id, 'resume_id' => $resume->id]);

        return $session;
    }

    /**
     * Submit an answer and evaluate it
     */
    public function submitAnswer(InterviewSession $session, InterviewQuestion $question, string $answerText, ?string $answerAudio = null, ?int $durationSeconds = null): InterviewAnswer
    {
        $session->load('resume.analysis');

        $resumeText = $session->resume->analysis->extracted_text ?? '';

        $evaluation = $this->openAI->evaluateAnswer($question->question_text, $answerText, $resumeText);

        $answer = InterviewAnswer::create([
            'interview_question_id' => $question->id,
            'answer_text' => $answerText,
            'answer_audio_path' => $answerAudio,
            'duration_seconds' => $durationSeconds,
            'evaluation_json' => $evaluation,
            'score' => $evaluation['score'] ?? null,
        ]);

        // Update session score
        $this->updateOverallScore($session);

        return $answer;
    }

    /**
     * Compute and persist overall session score
     */
    public function updateOverallScore(InterviewSession $session): void
    {
        $session->load('questions.answer');

        $answers = $session->questions->pluck('answer')->filter();

        if ($answers->isEmpty()) {
            return;
        }

        $averageScore = $answers->avg('score');

        $session->update(['overall_score' => round($averageScore, 2)]);
    }
}
