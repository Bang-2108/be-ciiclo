<?php

namespace App\Services;

use App\Repositories\ProfileRepository;
class ProfileService extends BaseService
{
    public function __construct(ProfileRepository $profileRepository)
    {
        parent::__construct($profileRepository);
    }
    public function getProfile()
    {
        return $this->repository->getProfile();
    }
}