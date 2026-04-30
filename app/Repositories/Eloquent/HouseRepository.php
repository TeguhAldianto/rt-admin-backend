<?php

namespace App\Repositories\Eloquent;

use App\Models\House;
use App\Models\HouseHistory;
use App\Repositories\Contracts\HouseRepositoryInterface;
use Illuminate\Support\Facades\DB;

class HouseRepository implements HouseRepositoryInterface
{
    protected House $model;

    public function __construct(House $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        // Menarik data rumah beserta histori yang aktif dan data penghuninya
        return $this->model->with(['houseHistories' => function ($query) {
            $query->with('occupant')->orderBy('created_at', 'desc');
        }])->get();
    }

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $house = $this->findById($id);
        $house->update($data);
        return $house;
    }

    public function assignOccupant(int $houseId, int $occupantId, string $startDate)
    {
        DB::beginTransaction();
        try {
            $house = $this->findById($houseId);

            // 1. Tutup histori sebelumnya (jika ada yang aktif)
            HouseHistory::where('house_id', $houseId)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'end_date' => $startDate
                ]);

            // 2. Buat histori penghuni baru
            HouseHistory::create([
                'house_id' => $houseId,
                'occupant_id' => $occupantId,
                'start_date' => $startDate,
                'is_active' => true
            ]);

            // 3. Ubah status rumah menjadi dihuni
            $house->update(['status' => 'dihuni']);

            DB::commit();
            return $house->load(['houseHistories.occupant']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
