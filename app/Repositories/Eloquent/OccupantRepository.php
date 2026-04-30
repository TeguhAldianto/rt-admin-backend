<?php

namespace App\Repositories\Eloquent;

use App\Models\Occupant;
use App\Repositories\Contracts\OccupantRepositoryInterface;

class OccupantRepository implements OccupantRepositoryInterface
{
    // Tambahkan tipe data Occupant di sini
    protected Occupant $model;

    public function __construct(Occupant $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    // Tambahkan 'int' pada $id
    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // Tambahkan 'int' pada $id
    public function update(int $id, array $data)
    {
        $occupant = $this->findById($id);
        $occupant->update($data);
        return $occupant;
    }

    // Tambahkan 'int' pada $id
    public function delete(int $id)
    {
        $occupant = $this->findById($id);
        return $occupant->delete();
    }
}
