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
        PassportInfo::create([
            'pilgrim_id' => 1,
            'numeroPasseport' => 'A12345678',
            'dateDelivrance' => Carbon::now()->subYears(2),
            'dateExpiration' => Carbon::now()->addYears(8),
        ]);

        PassportInfo::create([
            'pilgrim_id' => 2,
            'numeroPasseport' => 'B98765432',
            'dateDelivrance' => Carbon::now()->subYears(1),
            'dateExpiration' => Carbon::now()->addYears(9),
        ]);
    }
}