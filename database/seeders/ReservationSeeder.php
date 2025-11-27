<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Reservation::create([
            'pilgrim_id' => 1,
            'package_id' => 1,
            'room_id' => 1, // Assuming room 1 is for hotel 1
            'totalPrix' => 5000.00,
            'montantPaye' => 3000.00,
            'selectionne' => true,
        ]);

        \App\Models\Reservation::create([
            'pilgrim_id' => 2,
            'package_id' => 2,
            'room_id' => 4, // Assuming room 4 is for hotel 2 (first room of second hotel)
            'totalPrix' => 4000.00,
            'montantPaye' => 4000.00,
            'selectionne' => true,
        ]);
    }
}
