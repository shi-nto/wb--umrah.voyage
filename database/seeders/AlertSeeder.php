<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alert;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alert::create([
            'pilgrim_id' => 1,
            'type' => 'Health',
            'message' => 'Pilgrim has a medical condition requiring attention.',
        ]);

        Alert::create([
            'pilgrim_id' => 2,
            'type' => 'Payment',
            'message' => 'Outstanding payment reminder.',
        ]);
    }
}