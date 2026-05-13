<?php

namespace App\Services;

class BaseService
{
    protected object $repository;
    public function __construct(object $repository)
    {
        $this->repository = $repository;
    }
    public function all()
    {
        return $this->repository->all();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}