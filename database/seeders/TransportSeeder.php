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
            'reference' => 'RAM123',
            'price' => 1500.00,
        ]);

        \App\Models\Transport::create([
            'type' => 'Bus',
            'provider' => 'Local Bus Company',
            'departCity' => 'Makkah',
            'arriveCity' => 'Madinah',
            'departDate' => '2025-12-05',
            'arriveDate' => '2025-12-05',
            'status' => 'Pending',
            'reference' => 'BUS456',
            'price' => 200.00,
        ]);

        \App\Models\Transport::create([
            'type' => 'Flight',
            'provider' => 'Saudi Airlines',
            'departCity' => 'Jeddah',
            'arriveCity' => 'Madinah',
            'departDate' => '2025-12-10',
            'arriveDate' => '2025-12-10',
            'status' => 'Confirmed',
            'reference' => 'SA789',
            'price' => 300.00,
        ]);

        \App\Models\Transport::create([
            'type' => 'Train',
            'provider' => 'Haramain Express',
            'departCity' => 'Makkah',
            'arriveCity' => 'Madinah',
            'departDate' => '2025-12-15',
            'arriveDate' => '2025-12-15',
            'status' => 'Confirmed',
            'reference' => 'HE101',
            'price' => 150.00,
        ]);

        \App\Models\Transport::create([
            'type' => 'Flight',
            'provider' => 'Emirates',
            'departCity' => 'Dubai',
            'arriveCity' => 'Jeddah',
            'departDate' => '2025-12-20',
            'arriveDate' => '2025-12-20',
            'status' => 'Confirmed',
            'reference' => 'EK202',
            'price' => 1800.00,
        ]);

        \App\Models\Transport::create([
            'type' => 'Bus',
            'provider' => 'VIP Transport',
            'departCity' => 'Jeddah',
            'arriveCity' => 'Makkah',
            'departDate' => '2025-12-25',
            'arriveDate' => '2025-12-25',
            'status' => 'Pending',
            'reference' => 'VIP303',
            'price' => 250.00,
        ]);
    }
}
