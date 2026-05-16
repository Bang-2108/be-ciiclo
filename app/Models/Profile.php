<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'role',
        'bio',
        'education',
        'objective',
        'avatar',
        'cv_path',
        'is_available',
        'stats_experience',
        'stats_projects',
        'stats_internships',
    ];

    
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function socials(): HasMany
    {
        return $this->hasMany(Social::class);
    }
}