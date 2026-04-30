<?php

namespace App\Repositories\Contracts;

interface HouseRepositoryInterface
{
    public function getAll();
    public function findById(int $id);
    public function update(int $id, array $data);
    public function assignOccupant(int $houseId, int $occupantId, string $startDate);
}
