<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository extends BaseRepository
{
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }

    public function getAllSorted()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }
}