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
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan Faker dengan lokal bahasa Indonesia
        $faker = Faker::create('id_ID');
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // 1. Ambil 15 rumah pertama untuk diisi penghuni secara otomatis
        $houses = House::take(15)->get();

        foreach ($houses as $house) {
            /** @var \App\Models\House $house */

            // A. Buat Data Penghuni
            $status = $faker->randomElement(['tetap', 'kontrak']);
            $occupant = Occupant::create([
                'full_name' => $faker->name,
                'id_card_photo' => null, // Dikosongkan untuk dummy
                'occupant_status' => $status,
                'phone_number' => $faker->phoneNumber,
                'marital_status' => $faker->randomElement(['menikah', 'belum_menikah']),
            ]);

            // B. Ubah status rumah menjadi dihuni
            $house->update(['status' => 'dihuni']);

            // C. Buat History Rumah
            HouseHistory::create([
                'house_id' => $house->id,
                'occupant_id' => $occupant->id,
                // Tanggal masuk acak antara 1 sampai 12 bulan yang lalu
                'start_date' => Carbon::now()->subMonths(rand(1, 12))->format('Y-m-d'),
                'is_active' => true,
            ]);

            // D. Buat Data Pembayaran Iuran (Lunas dari bulan 1 sampai bulan saat ini)
            for ($m = 1; $m <= $currentMonth; $m++) {
                // Iuran Satpam
                Payment::create([
                    'occupant_id' => $occupant->id,
                    'payment_type' => 'satpam',
                    'amount' => 100000,
                    'for_month' => $m,
                    'for_year' => $currentYear,
                    'status' => 'lunas',
                    'paid_at' => Carbon::createFromDate($currentYear, $m, rand(1, 10))->format('Y-m-d'),
                ]);

                // Iuran Kebersihan
                Payment::create([
                    'occupant_id' => $occupant->id,
                    'payment_type' => 'kebersihan',
                    'amount' => 15000,
                    'for_month' => $m,
                    'for_year' => $currentYear,
                    'status' => 'lunas',
                    'paid_at' => Carbon::createFromDate($currentYear, $m, rand(1, 10))->format('Y-m-d'),
                ]);
            }
        }

        // 2. Buat Data Pengeluaran RT Dummy
        $expensesList = ['Perbaikan Selokan', 'Beli Lampu Jalan', 'Kas RT', 'Konsumsi Rapat Warga', 'Perbaikan Portal', 'Alat Kebersihan'];

        for ($m = 1; $m <= $currentMonth; $m++) {
            // Pengeluaran pasti: Gaji Satpam per bulan
            Expense::create([
                'description' => 'Gaji Satpam Bulan ' . Carbon::create()->month($m)->translatedFormat('F'),
                'amount' => 1500000,
                'expense_date' => Carbon::createFromDate($currentYear, $m, 28)->format('Y-m-d'),
            ]);

            // Pengeluaran acak (50% kemungkinan ada pengeluaran tambahan di bulan tersebut)
            if (rand(0, 1)) {
                Expense::create([
                    'description' => $faker->randomElement($expensesList),
                    'amount' => $faker->numberBetween(5, 50) * 10000, // Nominal acak antara 50.000 s/d 500.000
                    'expense_date' => Carbon::createFromDate($currentYear, $m, rand(1, 25))->format('Y-m-d'),
                ]);
            }
        }
    }
}
