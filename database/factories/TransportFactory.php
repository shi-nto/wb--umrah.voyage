<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transport>
 */
class TransportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['Flight', 'Bus', 'Train']),
            'provider' => $this->faker->company(),
            'departCity' => $this->faker->city(),
            'arriveCity' => $this->faker->city(),
            'departDate' => $this->faker->date(),
            'arriveDate' => $this->faker->date(),
            'status' => $this->faker->randomElement(['Confirmed', 'Pending', 'Cancelled']),
            'reference' => $this->faker->randomNumber(6),
        ];
    }
}
