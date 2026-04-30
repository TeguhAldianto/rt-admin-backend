<?php

namespace App\Services;

use App\Repositories\Contracts\OccupantRepositoryInterface;

class OccupantService
{
    // Tambahkan tipe data OccupantRepositoryInterface di sini
    protected OccupantRepositoryInterface $occupantRepository;

    public function __construct(OccupantRepositoryInterface $occupantRepository)
    {
        $this->occupantRepository = $occupantRepository;
    }

    public function getAllOccupants()
    {
        return $this->occupantRepository->getAll();
    }

    public function createOccupant(array $data)
    {
        if (isset($data['id_card_photo']) && $data['id_card_photo'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['id_card_photo']->store('ktp_photos', 'public');
            $data['id_card_photo'] = $path;
        }

        return $this->occupantRepository->create($data);
    }
}
