<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillTag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'canonical_name',
    ];

    /**
     * The resumes that belong to the skill tag.
     */
    public function resumes()
    {
        return $this->belongsToMany(Resume::class, 'resume_skill_tag');
    }
}
