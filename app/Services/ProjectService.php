<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Repositories\ProfileRepository;
use Illuminate\Http\UploadedFile;

class ProjectService extends BaseService
{
    protected ProfileRepository $profileRepo;
    protected StorageService $storageService;

    public function __construct(
        ProjectRepository $projectRepository,
        ProfileRepository $profileRepo,
        StorageService $storageService
    ) {
        parent::__construct($projectRepository);
        $this->profileRepo = $profileRepo;
        $this->storageService = $storageService;
    }
    public function getAdminProjects()
    {
        return $this->repository->getAllSorted()->map(function ($project) {
            if ($project->image) {
                $project->image = $this->storageService->url($project->image);
            }
            return $project;
        });
    }
    public function createProject(array $data, ?UploadedFile $imageFile)
    {
        $profile = $this->profileRepo->getProfile();
        $data['profile_id'] = $profile ? $profile->id : 1;
        if (isset($data['tech_stack'])) {
            $data['tech_stack'] = array_filter(array_map('trim', explode(',', $data['tech_stack'])));
        }
        if ($imageFile && $imageFile->isValid()) {
            $data['image'] = $this->storageService->upload($imageFile, 'projects');
        }
        $project = $this->repository->create($data);

        if ($project->image) {
            $project->image = $this->storageService->url($project->image);
        }

        return $project;
    }
    public function updateProject(int $id, array $data, ?UploadedFile $imageFile)
    {
        $project = $this->repository->find($id);
        $rawOldImage = $project ? $project->getRawOriginal('image') : null;

        if (isset($data['tech_stack'])) {
            $data['tech_stack'] = array_filter(array_map('trim', explode(',', $data['tech_stack'])));
        }

        if ($imageFile && $imageFile->isValid()) {
            if (!empty($rawOldImage)) {
                $this->storageService->delete($rawOldImage);
            }
            $data['image'] = $this->storageService->upload($imageFile, 'projects');
        } else {
            unset($data['image']);
        }

        $updatedProject = $this->repository->update($id, $data);

        if ($updatedProject && $updatedProject->image) {
            $updatedProject->image = $this->storageService->url($updatedProject->image);
        }

        return $updatedProject;
    }

    public function deleteProject(int $id)
    {
        $project = $this->repository->find($id);
        $rawImage = $project ? $project->getRawOriginal('image') : null;

        if (!empty($rawImage)) {
            $this->storageService->delete($rawImage);
        }

        return $this->repository->delete($id);
    }
}
