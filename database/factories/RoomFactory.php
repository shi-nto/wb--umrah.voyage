<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::factory(),
            'type' => $this->faker->randomElement(['Single', 'Double', 'Suite']),
            'capacity' => $this->faker->numberBetween(1, 5),
            'pricePerNight' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
