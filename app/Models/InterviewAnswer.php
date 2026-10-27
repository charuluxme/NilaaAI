<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'interview_question_id',
        'answer_text',
        'answer_audio_path',
        'duration_seconds',
        'evaluation_json',
        'score',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'duration_seconds' => 'integer',
        'evaluation_json' => 'array',
        'score' => 'float',
    ];

    /**
     * Get the question that owns the answer.
     */
    public function question()
    {
        return $this->belongsTo(InterviewQuestion::class, 'interview_question_id');
    }
}
