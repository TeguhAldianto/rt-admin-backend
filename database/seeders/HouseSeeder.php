<?php

namespace Database\Seeders; // <-- Ini sangat penting agar dikenali

use Illuminate\Database\Seeder;
use App\Models\House;

class HouseSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $houseNumber = 'Blok A - ' . str_pad($i, 2, '0', STR_PAD_LEFT);

            House::create([
                'house_number' => $houseNumber,
                'status' => 'tidak_dihuni',
            ]);
        }
    }
}
