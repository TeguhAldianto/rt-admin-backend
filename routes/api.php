<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OccupantController;
use App\Http\Controllers\API\HouseController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ExpenseController; // <-- Tambahan untuk Expense
use App\Http\Controllers\API\ReportController;

Route::prefix('v1')->group(function () {
    // Routes untuk Penghuni
    Route::apiResource('occupants', OccupantController::class);

    // Routes untuk Rumah
    Route::apiResource('houses', HouseController::class)->only(['index', 'show']);
    Route::post('houses/{house}/assign', [HouseController::class, 'assignOccupant']);

    // Routes untuk Pembayaran Iuran
    Route::post('payments', [PaymentController::class, 'store']);

    // Routes untuk Pengeluaran (Expenses)
    Route::apiResource('expenses', ExpenseController::class)->only(['index', 'store']); // <-- Route Expense

    // Routes untuk Laporan (Report)
    Route::get('reports/summary', [ReportController::class, 'summaryReport']);
    Route::get('reports/monthly-detail', [ReportController::class, 'monthlyDetail']);
});
