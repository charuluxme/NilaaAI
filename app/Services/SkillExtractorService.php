<?php

namespace App\Services;

/**
 * Skill Extractor Service - Extracts and normalizes skills from resume text
 */
class SkillExtractorService
{
    /**
     * Canonical skill mapping
     */
    protected array $skillMapping = [
        'php' => 'PHP',
        'laravel' => 'Laravel',
        'symfony' => 'Symfony',
        'react' => 'React.js',
        'reactjs' => 'React.js',
        'vue' => 'Vue.js',
        'vuejs' => 'Vue.js',
        'angular' => 'Angular',
        'node' => 'Node.js',
        'nodejs' => 'Node.js',
        'javascript' => 'JavaScript',
        'typescript' => 'TypeScript',
        'python' => 'Python',
        'java' => 'Java',
        'docker' => 'Docker',
        'kubernetes' => 'Kubernetes',
        'k8s' => 'Kubernetes',
        'aws' => 'AWS',
        'azure' => 'Azure',
        'gcp' => 'Google Cloud',
        'mysql' => 'MySQL',
        'postgres' => 'PostgreSQL',
        'postgresql' => 'PostgreSQL',
        'mongodb' => 'MongoDB',
        'redis' => 'Redis',
        'git' => 'Git',
        'github' => 'GitHub',
        'gitlab' => 'GitLab',
        'ci/cd' => 'CI/CD',
        'rest' => 'REST API',
        'restful' => 'REST API',
        'graphql' => 'GraphQL',
        'api' => 'API Development',
        'microservices' => 'Microservices',
        'agile' => 'Agile',
        'scrum' => 'Scrum',
        'tdd' => 'TDD',
        'testing' => 'Software Testing',
        'pytest' => 'PyTest',
        'phpunit' => 'PHPUnit',
        'jest' => 'Jest',
    ];

    /**
     * Extract skills from text with confidence scores
     *
     * @param string $text Resume text
     * @param array|null $sections Parsed sections (optional for better accuracy)
     * @return array Array of skills with confidence scores
     */
    public function extract(string $text, ?array $sections = null): array
    {
        $skills = [];
        $text = strtolower($text);
        
        // If sections available, prioritize skills section
        $skillsText = $sections['skills'] ?? $text;
        
        foreach ($this->skillMapping as $keyword => $canonical) {
            $confidence = $this->calculateConfidence($keyword, $text, $skillsText);
            
            if ($confidence > 0) {
                $skills[] = [
                    'name' => $keyword,
                    'canonical_name' => $canonical,
                    'confidence' => $confidence,
                ];
            }
        }
        
        // Sort by confidence descending
        usort($skills, fn($a, $b) => $b['confidence'] <=> $a['confidence']);
        
        return $skills;
    }

    /**
     * Calculate confidence score for a skill keyword
     */
    protected function calculateConfidence(string $keyword, string $fullText, string $skillsSection): float
    {
        $confidence = 0.0;
        
        // Exact word boundary match in skills section
        if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/i', $skillsSection)) {
            $confidence = 1.0;
        }
        // Exact match in full text
        elseif (preg_match('/\b' . preg_quote($keyword, '/') . '\b/i', $fullText)) {
            $confidence = 0.8;
        }
        // Fuzzy match (partial)
        elseif (stripos($fullText, $keyword) !== false) {
            $confidence = 0.5;
        }
        
        // Boost confidence based on frequency
        $count = substr_count(strtolower($fullText), strtolower($keyword));
        if ($count > 1) {
            $confidence = min(1.0, $confidence + ($count - 1) * 0.1);
        }
        
        return round($confidence, 2);
    }

    /**
     * Get canonical skill mapping
     */
    public function getSkillMapping(): array
    {
        return $this->skillMapping;
    }
}
