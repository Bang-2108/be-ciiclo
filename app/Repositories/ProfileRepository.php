<?php

namespace App\Repositories;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileRepository extends BaseRepository
{
    public function __construct(Profile $model)
    {
        parent::__construct($model);
    }
    public function getProfile()
    {
        return $this->model->with([
            'socials',
        ])
        ->first();
    }
}