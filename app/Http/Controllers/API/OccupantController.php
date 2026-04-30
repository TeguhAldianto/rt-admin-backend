<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\OccupantService;
use Illuminate\Http\Request;

class OccupantController extends Controller
{
    // Tambahkan tipe data OccupantService di sini
    protected OccupantService $occupantService;

    public function __construct(OccupantService $occupantService)
    {
        $this->occupantService = $occupantService;
    }

    // ... method index() dan store() tetap sama seperti sebelumnya ...
    public function index()
    {
        $occupants = $this->occupantService->getAllOccupants();
        return response()->json([
            'status' => 'success',
            'data' => $occupants
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'id_card_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'occupant_status' => 'required|in:kontrak,tetap',
            'phone_number' => 'required|string|max:15',
            'marital_status' => 'required|in:menikah,belum_menikah',
        ]);

        $occupant = $this->occupantService->createOccupant($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Penghuni berhasil ditambahkan',
            'data' => $occupant
        ], 201);
    }
}
