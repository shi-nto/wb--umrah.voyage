<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Package::create([
            'typePack' => 'Premium',
            'typePelerin' => 'Adult',
            'programme' => 'Full Umrah',
            'agent_id' => 1,
            'event_id' => 1,
        ]);

        \App\Models\Package::create([
            'typePack' => 'Standard',
            'typePelerin' => 'Adult',
            'programme' => 'Basic Umrah',
            'agent_id' => 2,
            'event_id' => 2,
        ]);
    }
}
