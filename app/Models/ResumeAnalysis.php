<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeAnalysis extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'resume_id',
        'extracted_text',
        'skills_json',
        'ats_score',
        'readability_score',
        'suggestions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'skills_json' => 'array',
        'ats_score' => 'integer',
        'readability_score' => 'float',
        'suggestions' => 'array',
    ];

    /**
     * Get the resume that owns the analysis.
     */
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
