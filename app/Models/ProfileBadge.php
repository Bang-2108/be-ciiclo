<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileBadge extends Model
{
    protected $fillable = [
        'profile_id',
        'label',
        'icon',
        'position'
    ];
}