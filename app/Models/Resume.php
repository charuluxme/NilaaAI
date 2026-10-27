<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'file_path',
        'original_filename',
        'mime_type',
        'size_bytes',
        'uploaded_at',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uploaded_at' => 'datetime',
        'size_bytes' => 'integer',
    ];

    /**
     * Get the user that owns the resume.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the analysis for the resume.
     */
    public function analysis()
    {
        return $this->hasOne(ResumeAnalysis::class);
    }

    /**
     * Get the interview sessions for the resume.
     */
    public function interviewSessions()
    {
        return $this->hasMany(InterviewSession::class);
    }

    /**
     * Get the feedbacks for the resume.
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * The skill tags that belong to the resume.
     */
    public function skillTags()
    {
        return $this->belongsToMany(SkillTag::class, 'resume_skill_tag');
    }
}
