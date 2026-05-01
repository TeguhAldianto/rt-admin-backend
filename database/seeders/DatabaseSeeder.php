<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// Hapus baris use Database\Seeders\HouseSeeder; dan DummyDataSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HouseSeeder::class,
            DummyDataSeeder::class,
        ]);
    }
}
