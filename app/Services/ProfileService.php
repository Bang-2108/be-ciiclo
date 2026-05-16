<?php

namespace App\Services;

use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Log;

class ProfileService extends BaseService
{
    protected StorageService $storageService;

    public function __construct(ProfileRepository $profileRepository, StorageService $storageService)
    {
        parent::__construct($profileRepository);
        $this->storageService = $storageService;
    }

    public function getProfile()
    {
        return $this->repository->getProfile();
    }

    public function updateProfile(array $data)
    {
        $profile = $this->getProfile();

        if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
            $data['avatar'] = $this->storageService->upload($data['avatar'], 'avatars');
        }
        if (isset($data['cv_file']) && $data['cv_file'] instanceof \Illuminate\Http\UploadedFile) {
            $data['cv_path'] = $this->storageService->upload($data['cv_file'], 'cvs');
            unset($data['cv_file']);
        }

        return $this->repository->update($profile->id, $data);
    }
}