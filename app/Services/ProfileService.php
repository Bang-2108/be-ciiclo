<?php
namespace App\Services;
use App\Http\Requests\ProfileRequest;
use App\Repositories\ProfileRepository;
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
            $profile->avatar = $this->storageService->url($profile->avatar);
            $profile->cv_path = $this->storageService->url($profile->cv_path);
        }
        return $profile;
    }

    public function updateProfile(ProfileRequest $request)
    {
        $profile = $this->repository->getProfile();
        $rawOldAvatar = $profile ? $profile->getRawOriginal('avatar') : null;
        $rawOldCv = $profile ? $profile->getRawOriginal('cv_path') : null;
        if ($rawOldAvatar && str_contains($rawOldAvatar, 'http')) {
            $rawOldAvatar = ltrim(parse_url($rawOldAvatar, PHP_URL_PATH), '/');
            $rawOldAvatar = str_replace(config('filesystems.disks.s3.bucket') . '/', '', $rawOldAvatar);
        }
        if ($rawOldCv && str_contains($rawOldCv, 'http')) {
            $rawOldCv = ltrim(parse_url($rawOldCv, PHP_URL_PATH), '/');
            $rawOldCv = str_replace(config('filesystems.disks.s3.bucket') . '/', '', $rawOldCv);
        }

        $data = $request->validated();
        unset($data['cv_file']);

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            if (!empty($rawOldAvatar)) {
                $this->storageService->delete($rawOldAvatar);
            }
            $data['avatar'] = $this->storageService->upload($request->file('avatar'), 'avatars');
        } else {
            unset($data['avatar']);
        }

        if ($request->hasFile('cv_file') && $request->file('cv_file')->isValid()) {
            if (!empty($rawOldCv)) {
                $this->storageService->delete($rawOldCv);
            }
            $data['cv_path'] = $this->storageService->upload($request->file('cv_file'), 'cvs');
        }

        $updatedProfile = $this->repository->update($profile->id, $data);
        if ($updatedProfile) {
            $updatedProfile->avatar = $this->storageService->url($updatedProfile->avatar);
            $updatedProfile->cv_path = $this->storageService->url($updatedProfile->cv_path);
        }
        return $updatedProfile;
    }
}