<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PackageHotel;

class PackageHotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PackageHotel::create([
            'package_id' => 1,
            'hotel_id' => 1,
            'city' => 'Makkah',
            'nights' => 5,
        ]);

        PackageHotel::create([
            'package_id' => 1,
            'hotel_id' => 2,
            'city' => 'Madinah',
            'nights' => 3,
        ]);

        PackageHotel::create([
            'package_id' => 2,
            'hotel_id' => 3,
            'city' => 'Makkah',
            'nights' => 4,
        ]);

        PackageHotel::create([
            'package_id' => 2,
            'hotel_id' => 4,
            'city' => 'Madinah',
            'nights' => 2,
        ]);

        PackageHotel::create([
            'package_id' => 3,
            'hotel_id' => 5,
            'city' => 'Makkah',
            'nights' => 6,
        ]);

        PackageHotel::create([
            'package_id' => 3,
            'hotel_id' => 6,
            'city' => 'Madinah',
            'nights' => 4,
        ]);
    }
}