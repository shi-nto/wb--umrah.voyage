<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Transport::create([
            'type' => 'Flight',
            'provider' => 'Royal Air Maroc',
            'departCity' => 'Casablanca',
            'arriveCity' => 'Jeddah',
            'departDate' => '2025-12-01',
            'arriveDate' => '2025-12-01',
            'status' => 'Confirmed',
        ]);

        \App\Models\Transport::create([
            'type' => 'Bus',
            'provider' => 'Local Bus Company',
            'departCity' => 'Makkah',
            'arriveCity' => 'Madinah',
            'departDate' => '2025-12-05',
            'arriveDate' => '2025-12-05',
            'status' => 'Pending',
        ]);
    }
}
