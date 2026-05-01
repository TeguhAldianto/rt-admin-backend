<?php

namespace App\Services;

use App\Repositories\Contracts\OccupantRepositoryInterface;
use Illuminate\Support\Facades\Storage; // Sekarang ini akan kita gunakan

class OccupantService
{
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

    public function updateOccupant(int $id, array $data)
    {
        // 1. Ambil data penghuni yang lama
        $occupant = $this->occupantRepository->findById($id);

        if (isset($data['id_card_photo']) && $data['id_card_photo'] instanceof \Illuminate\Http\UploadedFile) {
            // 2. Jika ada foto KTP lama, hapus dari storage agar tidak memenuhi hardisk server
            if ($occupant->id_card_photo && Storage::disk('public')->exists($occupant->id_card_photo)) {
                Storage::disk('public')->delete($occupant->id_card_photo);
            }

            // 3. Simpan foto KTP yang baru
            $path = $data['id_card_photo']->store('ktp_photos', 'public');
            $data['id_card_photo'] = $path;

        } else {
            // Jika tidak ada upload foto baru, hapus key ini dari array agar foto lama tidak tertimpa NULL
            unset($data['id_card_photo']);
        }

        return $this->occupantRepository->update($id, $data);
    }
}
