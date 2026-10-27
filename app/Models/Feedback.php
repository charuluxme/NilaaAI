<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedbacks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'resume_id',
        'interview_session_id',
        'feedback_text',
        'categories',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'categories' => 'array',
    ];

    /**
     * Get the resume that owns the feedback.
     */
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

    /**
     * Get the interview session that owns the feedback.
     */
    public function interviewSession()
    {
        return $this->belongsTo(InterviewSession::class);
    }
}
