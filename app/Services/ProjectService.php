<?php
namespace App\Services;
use App\Repositories\ProjectRepository;
use App\Repositories\ProfileRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

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
        $newUploadedPath = null;

        try {
            return DB::transaction(function () use ($data, $imageFile, &$newUploadedPath) {
                $profile = $this->profileRepo->getProfile();
                $data['profile_id'] = $profile ? $profile->id : 1;

                if ($imageFile && $imageFile->isValid()) {
                    $newUploadedPath = $this->storageService->upload($imageFile, 'projects');
                    $data['image'] = $newUploadedPath;
                }

                $project = $this->repository->create($data);

                if ($project->image) {
                    $project->image = $this->storageService->url($project->image);
                }

                return $project;
            });
        } catch (Exception $e) {
            if ($newUploadedPath) {
                $this->storageService->delete($newUploadedPath);
            }

            Log::error('Create Project Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateProject(int $id, array $data, ?UploadedFile $imageFile)
    {
        $project = $this->repository->find($id);
        $rawOldImage = $project ? $project->getRawOriginal('image') : null;
        $newUploadedPath = null;

        try {
            return DB::transaction(function () use ($id, $data, $imageFile, $rawOldImage, &$newUploadedPath) {
                if ($imageFile && $imageFile->isValid()) {
                    $newUploadedPath = $this->storageService->upload($imageFile, 'projects');
                    $data['image'] = $newUploadedPath;
                } else {
                    unset($data['image']);
                }

                $updatedProject = $this->repository->update($id, $data);

                if ($newUploadedPath && !empty($rawOldImage)) {
                    $this->storageService->delete($rawOldImage);
                }

                if ($updatedProject && $updatedProject->image) {
                    $updatedProject->image = $this->storageService->url($updatedProject->image);
                }

                return $updatedProject;
            });
        } catch (Exception $e) {
            if ($newUploadedPath) {
                $this->storageService->delete($newUploadedPath);
            }

            Log::error("Update Project ID {$id} Failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteProject(int $id)
    {
        $project = $this->repository->find($id);
        $rawImage = $project ? $project->getRawOriginal('image') : null;

        try {
            DB::transaction(function () use ($id) {
                $this->repository->delete($id);
            });

            if (!empty($rawImage)) {
                $this->storageService->delete($rawImage);
            }

            return true;
        } catch (Exception $e) {
            Log::error("Delete Project ID {$id} Failed: " . $e->getMessage());
            throw $e;
        }
    }
}