<?php

namespace App\Repositories\Contracts;

interface OccupantRepositoryInterface
{
    public function getAll();
    public function findById(int $id); // Tambahkan 'int'
    public function create(array $data);
    public function update(int $id, array $data); // Tambahkan 'int'
    public function delete(int $id); // Tambahkan 'int'
}
