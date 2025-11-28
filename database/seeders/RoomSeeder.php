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
        $hotels = \App\Models\Hotel::all();
        foreach ($hotels as $hotel) {
            $numRooms = rand(1, 20);
            \App\Models\Room::factory($numRooms)->create([
                'hotel_id' => $hotel->id,
            ]);
        }
    }
}