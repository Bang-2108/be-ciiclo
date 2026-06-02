<?php

namespace App\Services;

use App\Repositories\ContactRepository;

class ContactService extends BaseService
{
    public function __construct(ContactRepository $contactRepository)
    {
        parent::__construct($contactRepository);
    }

    public function getAdminContacts()
    {
        return $this->repository->getAllSorted();
    }

    public function markAsRead($id)
    {
        return $this->repository->update($id, ['status' => 'read']);
    }
}