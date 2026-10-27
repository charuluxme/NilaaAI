<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'resume_id',
        'role_applied',
        'started_at',
        'completed_at',
        'overall_score',
        'session_metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'overall_score' => 'float',
        'session_metadata' => 'array',
    ];

    /**
     * Get the resume that owns the interview session.
     */
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

    /**
     * Get the questions for the interview session.
     */
    public function questions()
    {
        return $this->hasMany(InterviewQuestion::class);
    }

    /**
     * Get the feedbacks for the interview session.
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
