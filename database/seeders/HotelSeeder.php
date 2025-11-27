<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Hotel::create([
            'nom' => 'Hotel Al Safat',
            'ville' => 'Makkah',
            'distanceMasjid' => 500,
        ]);

        \App\Models\Hotel::create([
            'nom' => 'Hotel Madinah Plaza',
            'ville' => 'Madinah',
            'distanceMasjid' => 300,
        ]);
    }
}
