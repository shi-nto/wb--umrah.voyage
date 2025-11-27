<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->company . ' Hotel',
            'ville' => $this->faker->city(),
            'distanceMasjid' => $this->faker->numberBetween(100, 2000),
        ];
    }
}
