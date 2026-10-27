<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'interview_session_id',
        'question_text',
        'question_type',
        'difficulty',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'difficulty' => 'integer',
    ];

    /**
     * Get the interview session that owns the question.
     */
    public function interviewSession()
    {
        return $this->belongsTo(InterviewSession::class);
    }

    /**
     * Get the answer for the question.
     */
    public function answer()
    {
        return $this->hasOne(InterviewAnswer::class);
    }
}
