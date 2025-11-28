<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttachPackageRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Package::all()->each(function ($package) {
            // Attach random transports (1-3 per package)
            $transportIds = \App\Models\Transport::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $package->transports()->syncWithoutDetaching($transportIds->toArray());

            // Attach random hotels (1-2 per package)
            $hotelIds = \App\Models\Hotel::inRandomOrder()->take(rand(1, 2))->pluck('id');
            foreach ($hotelIds as $hotelId) {
                $hotel = \App\Models\Hotel::find($hotelId);
                $package->hotels()->syncWithoutDetaching([$hotelId => ['city' => $hotel->ville, 'nights' => rand(3, 7)]]);
            }
        });
    }
}