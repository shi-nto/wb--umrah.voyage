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
            'direction' => 'Outbound',
            'segment_order' => 1,
        ]);

        PackageTransport::create([
            'package_id' => 1,
            'transport_id' => 3,
            'direction' => 'Internal',
            'segment_order' => 2,
        ]);

        PackageTransport::create([
            'package_id' => 2,
            'transport_id' => 2,
            'direction' => 'Internal',
            'segment_order' => 1,
        ]);

        PackageTransport::create([
            'package_id' => 2,
            'transport_id' => 4,
            'direction' => 'Internal',
            'segment_order' => 2,
        ]);

        PackageTransport::create([
            'package_id' => 3,
            'transport_id' => 5,
            'direction' => 'Outbound',
            'segment_order' => 1,
        ]);

        PackageTransport::create([
            'package_id' => 3,
            'transport_id' => 6,
            'direction' => 'Inbound',
            'segment_order' => 3,
        ]);
    }
}