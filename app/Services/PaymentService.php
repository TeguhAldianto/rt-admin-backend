<?php

namespace App\Services;

use App\Repositories\Contracts\PaymentRepositoryInterface;
use Carbon\Carbon;

class PaymentService
{
    protected PaymentRepositoryInterface $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function processPayment(array $data)
    {
        $type = $data['payment_type']; // 'satpam' atau 'kebersihan'
        $amount = $type === 'satpam' ? 100000 : 15000;
        $period = $data['payment_period']; // 'bulan' atau 'tahun'
        $startMonth = $data['start_month'];
        $year = $data['year'];
        $now = Carbon::now()->format('Y-m-d');

        $payments = [];

        if ($period === 'tahun') {
            // Generate pembayaran untuk 12 bulan dari bulan mulai
            for ($i = 0; $i < 12; $i++) {
                $month = $startMonth + $i;
                $paymentYear = $year;

                // Jika bulannya melebihi 12 (Desember), reset ke Januari tahun depannya
                if ($month > 12) {
                    $month -= 12;
                    $paymentYear++;
                }

                $payments[] = [
                    'occupant_id' => $data['occupant_id'],
                    'payment_type' => $type,
                    'amount' => $amount,
                    'for_month' => $month,
                    'for_year' => $paymentYear,
                    'status' => 'lunas',
                    'paid_at' => $now,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            $this->paymentRepository->createMultiple($payments);
            return ['message' => 'Pembayaran 1 tahun berhasil dicatat.'];
        }

        // Jika pembayaran per bulan
        $payment = $this->paymentRepository->create([
            'occupant_id' => $data['occupant_id'],
            'payment_type' => $type,
            'amount' => $amount,
            'for_month' => $startMonth,
            'for_year' => $year,
            'status' => 'lunas',
            'paid_at' => $now,
        ]);

        return ['message' => 'Pembayaran 1 bulan berhasil dicatat.', 'data' => $payment];
    }
}
