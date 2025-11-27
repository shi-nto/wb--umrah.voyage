<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Event::create([
            'code' => 'GF_01/12 - 14/12_CMN BAH MEI',
            'departDate' => '2025-12-01',
            'returnDate' => '2025-12-14',
            'departCity' => 'Casablanca',
            'destinations' => 'BAH, MEI',
            'description' => 'Umrah trip from Casablanca to Bahrain and Medina',
        ]);

        \App\Models\Event::create([
            'code' => 'GF_15/12 - 28/12_RBT JED MAD',
            'departDate' => '2025-12-15',
            'returnDate' => '2025-12-28',
            'departCity' => 'Rabat',
            'destinations' => 'JED, MAD',
            'description' => 'Umrah trip from Rabat to Jeddah and Madinah',
        ]);
    }
}
