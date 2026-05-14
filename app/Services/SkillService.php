<?php

namespace App\Services;

use App\Repositories\SkillRepository;
use App\Repositories\ProfileRepository;

class SkillService extends BaseService
{
    protected ProfileRepository $profileRepo;

    public function __construct(
        SkillRepository $skillRepository,
        ProfileRepository $profileRepo
    ) {
        parent::__construct($skillRepository);
        $this->profileRepo = $profileRepo;
    }
    public function create(array $data)
    {
        $profile = $this->profileRepo->getProfile();
        
        $data['profile_id'] = $profile->id;
        
        return $this->repository->create($data);
    }
    public function getAdminSkills()
    {
        return $this->repository->getAllSorted();
    }
    public function getSkillsGroupedByCategory()
    {
        return $this->repository->all()->groupBy('category');
    }
}