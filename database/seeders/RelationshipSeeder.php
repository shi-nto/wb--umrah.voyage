<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Relationship;

class RelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Relationship::create([
            'pilgrim_a_id' => 1,
            'pilgrim_b_id' => 2,
            'relationType' => 'Family',
        ]);

        Relationship::create([
            'pilgrim_a_id' => 2,
            'pilgrim_b_id' => 1,
            'relationType' => 'Family',
        ]);
    }
}