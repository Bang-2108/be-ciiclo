<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $fillable = [
        'profile_id', 
        'platform', 
        'icon', 
        'url', 
        'sort_order'];
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}