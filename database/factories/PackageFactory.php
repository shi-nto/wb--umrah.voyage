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
            'agent_id' => \App\Models\Agent::inRandomOrder()->first()->id ?? null,
            'event_id' => \App\Models\Event::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
