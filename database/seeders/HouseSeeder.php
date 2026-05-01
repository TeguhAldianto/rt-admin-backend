<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\House;

class HouseSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            House::create([
                'house_number' => 'Blok A - ' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'status' => 'tidak_dihuni',
            ]);
        }
    }
}
