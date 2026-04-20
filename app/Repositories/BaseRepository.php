<?php
namespace App\Repositories;

class BaseRepository {
    protected $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function all() { return $this->model->all(); }
    public function find($id) { return $this->model->findOrFail($id); }
    public function create(array $data) { return $this->model->create($data); }
    public function update($id, array $data) {
        $item = $this->find($id);
        $item->update($data);
        return $item;
    }
    public function delete($id) { return $this->find($id)->delete(); }
}