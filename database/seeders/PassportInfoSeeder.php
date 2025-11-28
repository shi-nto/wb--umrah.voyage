<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PassportInfo;
use Carbon\Carbon;

class PassportInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pilgrims = \App\Models\Pilgrim::all();
        foreach ($pilgrims as $pilgrim) {
            PassportInfo::factory()->create([
                'pilgrim_id' => $pilgrim->id,
            ]);
        }
    }
}