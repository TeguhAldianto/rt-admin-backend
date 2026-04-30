<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'occupant_id' => 'required|exists:occupants,id',
            'payment_type' => 'required|in:satpam,kebersihan',
            'payment_period' => 'required|in:bulan,tahun',
            'start_month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000'
        ]);

        $result = $this->paymentService->processPayment($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => $result['message'],
            'data' => $result['data'] ?? null
        ], 201);
    }
}
