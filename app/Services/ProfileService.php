<?php

namespace App\Services;

use App\Http\Requests\ProfileRequest;
use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileService extends BaseService
{
    protected StorageService $storageService;

    public function __construct(
        ProfileRepository $profileRepository,
        StorageService $storageService
    ) {
        parent::__construct($profileRepository);
        $this->storageService = $storageService;
    }

    public function getProfile()
    {
        $profile = $this->repository->getProfile();
        if ($profile) {
            $profile->avatar = $profile->avatar ? $this->storageService->url($profile->avatar) : null;
            $profile->cv_path = $profile->cv_path ? $this->storageService->url($profile->cv_path) : null;
        }
        return $profile;
    }

    public function updateProfile(ProfileRequest $request)
    {
        $profile = $this->repository->getProfile();
        $rawOldAvatar = $profile ? $profile->getRawOriginal('avatar') : null;
        $rawOldCv = $profile ? $profile->getRawOriginal('cv_path') : null;

        $data = $request->validated();
        unset($data['cv_file']);
        $uploadedFiles = [];

        try {
            $updatedProfile = DB::transaction(function () use ($request, $profile, &$data, &$uploadedFiles) {

                if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                    $data['avatar'] = $this->storageService->upload($request->file('avatar'), 'avatars');
                    $uploadedFiles[] = $data['avatar'];
                } else {
                    unset($data['avatar']);
                }

                if ($request->hasFile('cv_file') && $request->file('cv_file')->isValid()) {
                    $data['cv_path'] = $this->storageService->upload($request->file('cv_file'), 'cvs');
                    $uploadedFiles[] = $data['cv_path'];
                }

                return $this->repository->update($profile->id, $data);
            });
            if ($updatedProfile) {
                if ($request->hasFile('avatar') && !empty($rawOldAvatar)) {
                    $this->storageService->delete($rawOldAvatar);
                }
                if ($request->hasFile('cv_file') && !empty($rawOldCv)) {
                    $this->storageService->delete($rawOldCv);
                }

                $updatedProfile->avatar = $updatedProfile->avatar ? $this->storageService->url($updatedProfile->avatar) : null;
                $updatedProfile->cv_path = $updatedProfile->cv_path ? $this->storageService->url($updatedProfile->cv_path) : null;
            }

            return $updatedProfile;
        } catch (\Exception $e) {
            foreach ($uploadedFiles as $filePath) {
                $this->storageService->delete($filePath);
            }

            Log::error('Profile Update Transaction Failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
