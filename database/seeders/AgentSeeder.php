<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Agent::create([
            'nom' => 'Agent One',
            'telephone' => '0645678901',
        ]);

        \App\Models\Agent::create([
            'nom' => 'Agent Two',
            'telephone' => '0656789012',
        ]);
    }
}
