<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    protected ExpenseService $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index()
    {
        $expenses = $this->expenseService->getAllExpenses();
        return response()->json([
            'status' => 'success',
            'data' => $expenses
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'expense_date' => 'required|date'
        ]);

        $expense = $this->expenseService->recordExpense($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengeluaran berhasil dicatat.',
            'data' => $expense
        ], 201);
    }
}
