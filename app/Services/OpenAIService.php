<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

/**
 * OpenAI Client Service - Wrapper for OpenAI API calls
 */
class OpenAIService
{
    protected Client $client;
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('openai.api_key');
        $this->model = config('openai.model', 'gpt-4');
        
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'timeout' => 60,
        ]);
    }

    /**
     * Generate interview questions based on resume
     */
    public function generateInterviewQuestions(string $resumeText, string $role): array
    {
        $prompt = $this->buildQuestionGenerationPrompt($resumeText, $role);
        
        try {
            $response = $this->chat([
                ['role' => 'system', 'content' => 'You are an expert technical interviewer for Backend PHP/Laravel roles.'],
                ['role' => 'user', 'content' => $prompt]
            ]);
            
            $content = $response['choices'][0]['message']['content'] ?? '';
            
            // Parse JSON response
            $questions = json_decode($content, true);
            
            if (!is_array($questions)) {
                throw new \Exception('Invalid response format from OpenAI');
            }
            
            Log::info('Generated interview questions', [
                'role' => $role,
                'count' => count($questions)
            ]);
            
            return $questions;
            
        } catch (\Exception $e) {
            Log::error('Failed to generate interview questions', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Evaluate an interview answer
     */
    public function evaluateAnswer(string $question, string $answer, string $resumeText): array
    {
        $prompt = $this->buildAnswerEvaluationPrompt($question, $answer, $resumeText);
        
        try {
            $response = $this->chat([
                ['role' => 'system', 'content' => 'You are an objective technical evaluator.'],
                ['role' => 'user', 'content' => $prompt]
            ]);
            
            $content = $response['choices'][0]['message']['content'] ?? '';
            
            // Parse JSON response
            $evaluation = json_decode($content, true);
            
            if (!is_array($evaluation)) {
                throw new \Exception('Invalid response format from OpenAI');
            }
            
            return $evaluation;
            
        } catch (\Exception $e) {
            Log::error('Failed to evaluate answer', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Compute overall session score
     */
    public function computeOverallScore(array $evaluations): array
    {
        $prompt = $this->buildSessionSummaryPrompt($evaluations);
        
        try {
            $response = $this->chat([
                ['role' => 'system', 'content' => 'You are a scoring aggregator that weights technical answers 60%, behavioral 25%, communication 15%.'],
                ['role' => 'user', 'content' => $prompt]
            ]);
            
            $content = $response['choices'][0]['message']['content'] ?? '';
            
            return json_decode($content, true) ?? [];
            
        } catch (\Exception $e) {
            Log::error('Failed to compute overall score', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Rewrite a resume bullet point
     */
    public function rewriteBullet(string $bullet, string $role = 'Backend Developer', string $seniority = 'Mid'): string
    {
        $prompt = "Rewrite this resume bullet to be ATS-friendly, achievement-focused, and include measurable impact. Preserve technical keywords.\n\n";
        $prompt .= "Original bullet: \"{$bullet}\"\n";
        $prompt .= "Context: role = \"{$role}\", seniority = \"{$seniority}\"\n\n";
        $prompt .= "Return: one-line bullet, active voice, starts with strong action verb, includes metric if possible.";
        
        try {
            $response = $this->chat([
                ['role' => 'system', 'content' => 'You are a concise resume copywriter.'],
                ['role' => 'user', 'content' => $prompt]
            ]);
            
            return trim($response['choices'][0]['message']['content'] ?? $bullet);
            
        } catch (\Exception $e) {
            Log::error('Failed to rewrite bullet', ['error' => $e->getMessage()]);
            return $bullet;
        }
    }

    /**
     * Make a chat completion request
     */
    protected function chat(array $messages): array
    {
        $response = $this->client->post('chat/completions', [
            'json' => [
                'model' => $this->model,
                'messages' => $messages,
                'temperature' => config('openai.temperature', 0.7),
                'max_tokens' => config('openai.max_tokens', 2000),
            ]
        ]);
        
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Build question generation prompt
     */
    protected function buildQuestionGenerationPrompt(string $resumeText, string $role): string
    {
        return <<<PROMPT
Analyze the following resume text and generate 6 interview questions tailored to the candidate for the role: {$role}.

Mix of: 2 behavioral, 2 design/architecture, 2 coding/technical.

For each question return: id, question_text, type (behavioral|design|technical), difficulty (1-5), rationale (one-sentence why this question fits).

Resume text:
-------------
{$resumeText}
-------------

Return a JSON array.
PROMPT;
    }

    /**
     * Build answer evaluation prompt
     */
    protected function buildAnswerEvaluationPrompt(string $question, string $answer, string $resumeText): string
    {
        return <<<PROMPT
Given the question, the candidate's textual answer, and the original resume, evaluate the answer.

Return JSON with:
- score (0-100)
- key_strengths (array)
- weaknesses (array)
- suggestions (array of 3 actionable lines to improve)
- rewrite_resume_bullets (array of 1-3 revised bullet points to improve resume)

Input:
- question: "{$question}"
- answer: "{$answer}"
- resume_text: "{$resumeText}"

Return JSON. Use evidence from the answer.
PROMPT;
    }

    /**
     * Build session summary prompt
     */
    protected function buildSessionSummaryPrompt(array $evaluations): string
    {
        $evaluationsJson = json_encode($evaluations, JSON_PRETTY_PRINT);
        
        return <<<PROMPT
Given the set of question evaluations (each with score 0-100) compute weighted overall_score (0-100) and provide top 3 resume improvements and top 3 interview training suggestions.

Evaluations:
{$evaluationsJson}

Return JSON with: overall_score, resume_improvements (array), interview_training_suggestions (array).
PROMPT;
    }
}
