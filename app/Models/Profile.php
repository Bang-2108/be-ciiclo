<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'role',
        'description',
        'avatar'
    ];

    public function socials()
    {
        return $this->hasMany(ProfileSocial::class);
    }

    public function badges()
    {
        return $this->hasMany(ProfileBadge::class);
    }
}