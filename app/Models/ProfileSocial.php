<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileSocial extends Model
{
    protected $fillable = [
        'profile_id',
        'platform',
        'icon',
        'url'
    ];
}