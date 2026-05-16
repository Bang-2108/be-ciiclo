<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillRequest;
use App\Services\SkillService;
use Illuminate\Http\JsonResponse;

class SkillController extends Controller
{
    public function __construct(
        protected SkillService $skillService
    ) {}

    public function index(): JsonResponse
    {
        return $this->success($this->skillService->getAdminSkills());
    }
    public function store(SkillRequest $request): JsonResponse
    {
        $skill = $this->skillService->create($request->validated());
        return $this->success($skill, 'New skill created successfully', 201);
    }

    public function update(SkillRequest $request, $id): JsonResponse 
    {
        $skill = $this->skillService->update($id, $request->validated());
        return $this->success($skill, 'Skill updated successfully');
    }

    public function destroy($id): JsonResponse
    {
        $this->skillService->delete($id);
        return $this->success(null, 'Skill deleted successfully');
    }
}