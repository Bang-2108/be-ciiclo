<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $projectService
    ) {}
    public function index(): JsonResponse
    {
        try {
            $projects = $this->projectService->getAdminProjects();

            return $this->success(
                $projects,
                'Client projects retrieved successfully'
            );
        } catch (\Exception $e) {
            Log::error('Client Project Index Error: ' . $e->getMessage());
            return $this->error(
                'Internal server error',
                500
            );
        }
    }
}