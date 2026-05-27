<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $projectService
    ) {}

    public function index(): JsonResponse
    {
        return $this->success($this->projectService->getAdminProjects());
    }
    public function store(ProjectRequest $request): JsonResponse
    {
        $project = $this->projectService->createProject(
            $request->validated(),
            $request->file('image')
        );
        return $this->success($project, 'New project created successfully', 201);
    }
    public function update(ProjectRequest $request, $id): JsonResponse
    {
        $project = $this->projectService->updateProject(
            $id,
            $request->validated(),
            $request->file('image')
        );
        return $this->success($project, 'Project updated successfully');
    }
    public function destroy($id): JsonResponse
    {
        $this->projectService->deleteProject($id);
        return $this->success(null, 'Project deleted successfully');
    }
}
