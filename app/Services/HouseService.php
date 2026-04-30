<?php

namespace App\Services;

use App\Repositories\Contracts\HouseRepositoryInterface;

class HouseService
{
    protected HouseRepositoryInterface $houseRepository;

    public function __construct(HouseRepositoryInterface $houseRepository)
    {
        $this->houseRepository = $houseRepository;
    }

    public function getAllHouses()
    {
        return $this->houseRepository->getAll();
    }

    public function assignOccupantToHouse(int $houseId, array $data)
    {
        return $this->houseRepository->assignOccupant($houseId, $data['occupant_id'], $data['start_date']);
    }
}
