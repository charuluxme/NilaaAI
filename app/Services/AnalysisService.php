<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\ResumeAnalysis;
use App\Models\SkillTag;
use Illuminate\Support\Facades\Log;

/**
 * Analysis Service - Computes ATS score, readability, and generates suggestions
 */
class AnalysisService
{
    public function __construct(
        protected SkillExtractorService $skillExtractor
    ) {}

    /**
     * Analyze a resume and persist results
     */
    public function analyze(Resume $resume, array $parsedData): ResumeAnalysis
    {
        $text = $parsedData['full_text'];
        $sections = $parsedData['sections'];
        
        // Extract skills
        $skills = $this->skillExtractor->extract($text, $sections);
        
        // Calculate scores
        $atsScore = $this->calculateAtsScore($text, $skills);
        $readabilityScore = $this->calculateReadabilityScore($text);
        
        // Generate suggestions
        $suggestions = $this->generateSuggestions($text, $sections, $atsScore, $readabilityScore);
        
        // Create or update analysis (store suggestions as native array; model casts handle JSON)
        $analysis = $resume->analysis()->updateOrCreate(
            ['resume_id' => $resume->id],
            [
                'extracted_text' => $text,
                'skills_json' => $skills,
                'ats_score' => $atsScore,
                'readability_score' => $readabilityScore,
                'suggestions' => $suggestions,
            ]
        );
        
        // Sync skill tags
        $this->syncSkillTags($resume, $skills);
        
        Log::info('Resume analyzed', [
            'resume_id' => $resume->id,
            'ats_score' => $atsScore,
            'skills_count' => count($skills)
        ]);
        
        return $analysis;
    }

    /**
     * Calculate ATS (Applicant Tracking System) score
     */
    protected function calculateAtsScore(string $text, array $skills): int
    {
        $score = 50; // Base score
        
        // +1 per skill keyword found (max +30)
        $skillBonus = min(30, count($skills));
        $score += $skillBonus;
        
        // +5 if contact info present
        if ($this->hasContactInfo($text)) {
            $score += 5;
        }
        
        // +5 if has employment dates
        if (preg_match('/\d{4}\s*[-–]\s*\d{4}/', $text)) {
            $score += 5;
        }
        
        // +5 if has education section
        if (preg_match('/education|degree|university|college/i', $text)) {
            $score += 5;
        }
        
        // -10 if resume is too short
        $wordCount = str_word_count($text);
        if ($wordCount < 100) {
            $score -= 10;
        }
        
        // -5 if too long (over 1000 words suggests poor editing)
        if ($wordCount > 1000) {
            $score -= 5;
        }
        
        // Ensure score is between 0-100
        return max(0, min(100, $score));
    }

    /**
     * Check if text contains contact information
     */
    protected function hasContactInfo(string $text): bool
    {
        // Check for email
        $hasEmail = preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $text);
        
        // Check for phone
        $hasPhone = preg_match('/\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}/', $text);
        
        return $hasEmail || $hasPhone;
    }

    /**
     * Calculate readability score (simplified Flesch-like metric)
     */
    protected function calculateReadabilityScore(string $text): float
    {
        $sentences = preg_split('/[.!?]+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        $sentenceCount = count($sentences);
        
        if ($sentenceCount === 0) {
            return 0.0;
        }
        
        $words = str_word_count($text);
        $avgSentenceLength = $words / $sentenceCount;
        
        // Count "long" words (> 6 characters)
        preg_match_all('/\b\w{7,}\b/', $text, $matches);
        $longWords = count($matches[0]);
        $longWordRatio = $words > 0 ? ($longWords / $words) : 0;
        
        // Simple scoring: prefer moderate sentence length and moderate complexity
        $score = 100;
        
        // Penalize very long sentences
        if ($avgSentenceLength > 25) {
            $score -= min(30, ($avgSentenceLength - 25) * 2);
        }
        
        // Penalize too many long words
        if ($longWordRatio > 0.3) {
            $score -= min(20, ($longWordRatio - 0.3) * 100);
        }
        
        return max(0, min(100, round($score, 1)));
    }

    /**
     * Generate improvement suggestions
     */
    protected function generateSuggestions(string $text, array $sections, int $atsScore, float $readabilityScore): array
    {
        $suggestions = [];
        
        if ($atsScore < 70) {
            $suggestions[] = 'Add more relevant keywords and technical skills to improve ATS compatibility.';
        }
        
        if (!$this->hasContactInfo($text)) {
            $suggestions[] = 'Include contact information (email and phone number) at the top of your resume.';
        }
        
        if ($readabilityScore < 60) {
            $suggestions[] = 'Simplify sentence structure. Use shorter sentences and bullet points for better readability.';
        }
        
        if (str_word_count($text) < 200) {
            $suggestions[] = 'Expand your resume with more details about your experience, projects, and achievements.';
        }
        
        if (!preg_match('/\d+%|\d+x|increased|improved|reduced|achieved/i', $text)) {
            $suggestions[] = 'Add quantifiable achievements with metrics (e.g., "Improved performance by 40%").';
        }
        
        if (empty($sections['projects']) && empty($sections['experience'])) {
            $suggestions[] = 'Add a Projects or Experience section to showcase your work.';
        }
        
        // Sample bullet rewrites
        $suggestions[] = [
            'type' => 'bullet_rewrite',
            'original' => 'Worked on backend development',
            'improved' => 'Developed RESTful APIs using Laravel, serving 10K+ daily active users with 99.9% uptime',
        ];
        
        return $suggestions;
    }

    /**
     * Sync skill tags with resume
     */
    protected function syncSkillTags(Resume $resume, array $skills): void
    {
        $tagIds = [];
        
        foreach ($skills as $skill) {
            if ($skill['confidence'] >= 0.5) {
                $tag = SkillTag::firstOrCreate(
                    ['name' => $skill['name']],
                    ['canonical_name' => $skill['canonical_name']]
                );
                
                $tagIds[] = $tag->id;
            }
        }
        
        $resume->skillTags()->sync($tagIds);
    }
}
