<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    protected $model = Package::class;

    public function definition(): array
    {
        return [
            'typePack' => $this->faker->randomElement(['Standard', 'Premium', 'VIP']),
            'category' => $this->faker->randomElement(['Adult', 'Child']),
            'programme' => $this->faker->randomElement(['Full Umrah', 'Basic Umrah', 'Extended']),
            'agent_id' => null, // Will be set later or left null
            'event_id' => 1, // Assuming event with id 1 exists
        ];
    }
}
