<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Hotel;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            Room::create([
                'hotel_id' => $hotel->id,
                'type' => 'Single',
                'capacity' => 1,
                'pricePerNight' => 100.00,
            ]);

            Room::create([
                'hotel_id' => $hotel->id,
                'type' => 'Double',
                'capacity' => 2,
                'pricePerNight' => 150.00,
            ]);

            Room::create([
                'hotel_id' => $hotel->id,
                'type' => 'Triple',
                'capacity' => 3,
                'pricePerNight' => 200.00,
            ]);
        }
    }
}