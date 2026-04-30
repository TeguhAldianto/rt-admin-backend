<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\HouseService;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    protected HouseService $houseService;

    public function __construct(HouseService $houseService)
    {
        $this->houseService = $houseService;
    }

    public function index()
    {
        $houses = $this->houseService->getAllHouses();
        return response()->json([
            'status' => 'success',
            'data' => $houses
        ], 200);
    }

    public function assignOccupant(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'occupant_id' => 'required|exists:occupants,id',
            'start_date' => 'required|date'
        ]);

        $house = $this->houseService->assignOccupantToHouse($id, $validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Penghuni berhasil didaftarkan ke rumah, status rumah diperbarui menjadi dihuni.',
            'data' => $house
        ], 200);
    }
}
