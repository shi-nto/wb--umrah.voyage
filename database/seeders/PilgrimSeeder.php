<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PilgrimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Pilgrim::create([
            'nomFrancais' => 'Ahmed',
            'nomArabe' => 'أحمد',
            'prenomArabe' => 'محمد',
            'dateNaissance' => '1980-01-01',
            'ville' => 'Casablanca',
            'tel_1' => '0612345678',
            'tel_2' => '0623456789',
            'typeDiabete' => 'Type 1',
            'commentaire' => 'First time pilgrim',
        ]);

        \App\Models\Pilgrim::create([
            'nomFrancais' => 'Fatima',
            'nomArabe' => 'فاطمة',
            'prenomArabe' => 'زهرة',
            'dateNaissance' => '1975-05-15',
            'ville' => 'Rabat',
            'tel_1' => '0634567890',
            'tel_2' => null,
            'typeDiabete' => null,
            'commentaire' => 'Experienced pilgrim',
        ]);
    }
}
