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
        return $this->success($skill, 'Tạo kỹ năng mới thành công', 201);
    }

    public function update(SkillRequest $request, $id): JsonResponse 
    {
        $skill = $this->skillService->update($id, $request->validated());
        return $this->success($skill, 'Cập nhật kỹ năng thành công');
    }

    public function destroy($id): JsonResponse
    {
        $this->skillService->delete($id);
        return $this->success(null, 'Xóa kỹ năng thành công');
    }
}