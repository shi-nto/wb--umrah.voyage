<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PackageTransport;

class PackageTransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PackageTransport::create([
            'package_id' => 1,
            'transport_id' => 1,
        ]);

        PackageTransport::create([
            'package_id' => 2,
            'transport_id' => 2,
        ]);
    }
}