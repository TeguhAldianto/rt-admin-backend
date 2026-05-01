<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\House;
use App\Models\Occupant;
use App\Models\HouseHistory;
use App\Models\Payment;
use App\Models\Expense;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Ambil 15 rumah untuk diisi penghuni tetap (sesuai soal)
        $houses = House::take(15)->get();

        foreach ($houses as $house) {
            /** @var \App\Models\House $house */

            // Buat Data Penghuni
            $occupant = Occupant::create([
                'full_name' => $faker->name,
                'occupant_status' => 'tetap',
                'phone_number' => $faker->phoneNumber,
                'marital_status' => $faker->randomElement(['menikah', 'belum_menikah']),
            ]);

            // Set Rumah jadi Dihuni & Buat Histori
            $house->update(['status' => 'dihuni']);
            HouseHistory::create([
                'house_id' => $house->id,
                'occupant_id' => $occupant->id,
                'start_date' => Carbon::now()->startOfYear()->format('Y-m-d'),
                'is_active' => true,
            ]);

            // Generate Pembayaran dari Januari s/d Bulan Sekarang
            for ($m = 1; $m <= $currentMonth; $m++) {
                // Iuran Satpam (100k)
                Payment::create([
                    'occupant_id' => $occupant->id,
                    'payment_type' => 'satpam',
                    'amount' => 100000,
                    'for_month' => $m,
                    'for_year' => $currentYear,
                    'status' => 'lunas',
                    'paid_at' => Carbon::create($currentYear, $m, rand(1, 10))
                ]);

                // Iuran Kebersihan (15k)
                Payment::create([
                    'occupant_id' => $occupant->id,
                    'payment_type' => 'kebersihan',
                    'amount' => 15000,
                    'for_month' => $m,
                    'for_year' => $currentYear,
                    'status' => 'lunas',
                    'paid_at' => Carbon::create($currentYear, $m, rand(1, 10))
                ]);
            }
        }

        // Generate Pengeluaran RT (Gaji Satpam & Perbaikan)
        for ($m = 1; $m <= $currentMonth; $m++) {
            // Gaji Satpam Rutin
            Expense::create([
                'description' => 'Gaji Satpam Bulan ' . $m,
                'amount' => 1500000,
                'expense_date' => Carbon::create($currentYear, $m, 28)
            ]);

            // Pengeluaran Insidentil (Acak)
            if (rand(0, 1)) {
                Expense::create([
                    'description' => $faker->randomElement(['Perbaikan Lampu Jalan', 'Sedot WC Kas RT', 'Perbaikan Selokan']),
                    'amount' => $faker->numberBetween(100, 500) * 1000,
                    'expense_date' => Carbon::create($currentYear, $m, rand(1, 20))
                ]);
            }
        }
    }
}
