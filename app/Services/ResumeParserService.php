<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;

/**
 * Resume Parser Service - Extracts text and sections from resume files
 */
class ResumeParserService
{
    /**
     * Parse a resume file and extract structured data
     *
     * @param string $filePath Full path to the resume file
     * @param string $mimeType MIME type of the file
     * @return array Structured resume data
     */
    public function parse(string $filePath, string $mimeType): array
    {
        try {
            $text = $this->extractText($filePath, $mimeType);
            
            return [
                'full_text' => $text,
                'sections' => $this->extractSections($text),
                'raw_dates' => $this->extractDates($text),
            ];
        } catch (\Exception $e) {
            Log::error('Resume parsing failed', [
                'file' => $filePath,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Extract text from PDF or DOCX file
     */
    protected function extractText(string $filePath, string $mimeType): string
    {
        if ($mimeType === 'application/pdf') {
            return $this->extractFromPdf($filePath);
        }
        
        if (in_array($mimeType, [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ])) {
            return $this->extractFromDocx($filePath);
        }
        
        throw new \Exception("Unsupported file type: {$mimeType}");
    }

    /**
     * Extract text from PDF using spatie/pdf-to-text
     */
    protected function extractFromPdf(string $filePath): string
    {
        // Try configured path first
        $pdftotext = config('parser.pdftotext_path');

        // Auto-detect pdftotext on Windows or Unix if not configured
        if (empty($pdftotext)) {
            if (strncasecmp(PHP_OS_FAMILY, 'Windows', 7) === 0) {
                // 'where' works on Windows to locate executables
                $output = null;
                @exec('where pdftotext 2>NUL', $output);
                if (!empty($output) && is_array($output)) {
                    $pdftotext = $output[0];
                }
            } else {
                @exec('which pdftotext 2>/dev/null', $output);
                if (!empty($output) && is_array($output)) {
                    $pdftotext = $output[0];
                }
            }
        }

        if (empty($pdftotext) || !file_exists($pdftotext)) {
            throw new \Exception('pdftotext binary not found. Install poppler-utils or set parser.pdftotext_path in config.');
        }

        return (new Pdf($pdftotext))
            ->setPdf($filePath)
            ->text();
    }

    /**
     * Extract text from DOCX file
     * Note: This is a simplified version. For production, use PhpOffice/PhpWord
     */
    protected function extractFromDocx(string $filePath): string
    {
        // Simplified DOCX extraction - in production use PhpOffice\PhpWord
        $content = '';
        
        try {
            $zip = new \ZipArchive();
            if ($zip->open($filePath) === true) {
                $xml = $zip->getFromName('word/document.xml');
                $zip->close();
                
                if ($xml) {
                    $dom = new \DOMDocument();
                    $dom->loadXML($xml);
                    $content = strip_tags($dom->saveHTML());
                }
            }
        } catch (\Exception $e) {
            Log::warning('DOCX extraction failed, returning empty', ['error' => $e->getMessage()]);
        }
        
        return $content;
    }

    /**
     * Extract sections from resume text using regex patterns
     */
    protected function extractSections(string $text): array
    {
        $sections = [
            'experience' => [],
            'education' => [],
            'projects' => [],
            'skills' => [],
            'summary' => '',
        ];

        // Pattern to detect section headings
        $headingPatterns = [
            'experience' => '/(?:work\s+)?experience|employment\s+history/i',
            'education' => '/education|academic\s+background/i',
            'projects' => '/projects|portfolio/i',
            'skills' => '/skills|technical\s+skills|competencies/i',
            'summary' => '/summary|objective|profile/i',
        ];

        foreach ($headingPatterns as $section => $pattern) {
            if (preg_match($pattern, $text, $matches, PREG_OFFSET_CAPTURE)) {
                $startPos = $matches[0][1];
                
                // Find the next section or end of text
                $endPos = strlen($text);
                foreach ($headingPatterns as $otherSection => $otherPattern) {
                    if ($otherSection === $section) continue;
                    
                    if (preg_match($otherPattern, $text, $otherMatches, PREG_OFFSET_CAPTURE, $startPos + 1)) {
                        if ($otherMatches[0][1] < $endPos) {
                            $endPos = $otherMatches[0][1];
                        }
                    }
                }
                
                $sectionText = substr($text, $startPos, $endPos - $startPos);
                $sections[$section] = $this->cleanSectionText($sectionText);
            }
        }

        return $sections;
    }

    /**
     * Clean section text by removing extra whitespace
     */
    protected function cleanSectionText(string $text): string
    {
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    /**
     * Extract and normalize date ranges from text
     */
    protected function extractDates(string $text): array
    {
        $dates = [];
        
        // Pattern: Jan 2019 - Feb 2021, 01/2019 - 02/2021, etc.
        $pattern = '/(\w{3,}\.?\s+\d{4}|\d{1,2}\/\d{4})\s*[-–—]\s*(\w{3,}\.?\s+\d{4}|\d{1,2}\/\d{4}|present|current)/i';
        
        if (preg_match_all($pattern, $text, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $dates[] = [
                    'raw' => $match[0],
                    'start' => $this->normalizeDate($match[1]),
                    'end' => $this->normalizeDate($match[2]),
                ];
            }
        }
        
        return $dates;
    }

    /**
     * Normalize a date string to YYYY-MM format
     */
    protected function normalizeDate(string $date): ?string
    {
        $date = strtolower(trim($date));
        
        if (in_array($date, ['present', 'current'])) {
            return 'present';
        }
        
        // Try to parse the date
        try {
            $timestamp = strtotime($date);
            if ($timestamp !== false) {
                return date('Y-m', $timestamp);
            }
        } catch (\Exception $e) {
            // Ignore parsing errors
        }
        
        return null;
    }
}
