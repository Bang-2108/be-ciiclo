<?php

namespace App\Repositories;

use App\Models\Skill;

class SkillRepository extends BaseRepository
{
    public function __construct(Skill $model)
    {
        parent::__construct($model);
    }
    public function getAllSorted()
    {
        return $this->model->orderBy('sort_order', 'asc')->get();
    }
}