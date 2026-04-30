<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Mengambil summary saldo keseluruhan dan rekap grafis per bulan selama 1 tahun (tahun berjalan)
    public function summaryReport(Request $request)
    {
        $year = $request->query('year', Carbon::now()->year);

        // 1. Total Pemasukan dari iuran lunas di tahun tersebut
        $totalIncome = Payment::where('status', 'lunas')
            ->where('for_year', $year)
            ->sum('amount');

        // 2. Total Pengeluaran di tahun tersebut
        $totalExpense = Expense::whereYear('expense_date', $year)
            ->sum('amount');

        // 3. Hitung Saldo Sisa
        $currentBalance = $totalIncome - $totalExpense;

        // 4. Persiapan Data untuk Grafik Frontend (Agregasi Per Bulan)
        $monthlyData = [];
        for ($month = 1; $month <= 12; $month++) {
            $incomePerMonth = Payment::where('status', 'lunas')
                ->where('for_year', $year)
                ->where('for_month', $month)
                ->sum('amount');

            $expensePerMonth = Expense::whereYear('expense_date', $year)
                ->whereMonth('expense_date', $month)
                ->sum('amount');

            $monthlyData[] = [
                'month' => $month,
                'month_name' => Carbon::create()->month($month)->translatedFormat('F'),
                'income' => (int) $incomePerMonth,
                'expense' => (int) $expensePerMonth,
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'year' => $year,
                'summary' => [
                    'total_income' => (int) $totalIncome,
                    'total_expense' => (int) $totalExpense,
                    'current_balance' => (int) $currentBalance,
                ],
                'chart_data' => $monthlyData
            ]
        ], 200);
    }

    // Mengambil detail transaksi pada bulan tertentu
    public function monthlyDetail(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000'
        ]);

        $month = $request->month;
        $year = $request->year;

        // Tarik data pemasukan beserta informasi penghuninya
        $incomes = Payment::with('occupant')
            ->where('status', 'lunas')
            ->where('for_year', $year)
            ->where('for_month', $month)
            ->get();

        // Tarik data pengeluaran
        $expenses = Expense::whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'period' => "Bulan $month Tahun $year",
                'incomes' => $incomes,
                'expenses' => $expenses
            ]
        ], 200);
    }
}
