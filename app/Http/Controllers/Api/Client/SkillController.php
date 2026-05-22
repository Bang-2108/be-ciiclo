<?php

namespace App\Http\Controllers\Api\Client;  

use App\Http\Controllers\Controller;
use App\Services\SkillService;
use Illuminate\Http\JsonResponse;
class SkillController extends Controller
{
    public function __construct(
        protected SkillService $skillService
    ) {}
    public function index(): JsonResponse
    {
        $skills = $this->skillService
            ->getSkillsGroupedByCategory();
        return $this->success(
            $skills,
            'Skills retrieved successfully'
        );
    }
}