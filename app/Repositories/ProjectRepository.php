<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository extends BaseRepository
{
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

   public function getAllSorted()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }
}