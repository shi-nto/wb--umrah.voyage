<?php

namespace Database\Factories;

use App\Models\Pilgrim;
use Illuminate\Database\Eloquent\Factories\Factory;

class PilgrimFactory extends Factory
{
    protected $model = Pilgrim::class;

    public function definition(): array
    {
        return [
            'nomFrancais' => $this->faker->lastName(),
            'nomArabe' => $this->faker->lastName(),
            'prenomArabe' => $this->faker->firstName(),
            'dateNaissance' => $this->faker->date('Y-m-d', '-18 years'),
            'ville' => $this->faker->city(),
            'tel_1' => $this->faker->phoneNumber(),
            'tel_2' => $this->faker->optional()->phoneNumber(),
        ];
    }
}
