<?php

namespace Database\Factories;

use App\Models\PackageTransport;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageTransportFactory extends Factory
{
    protected $model = PackageTransport::class;

    public function definition(): array
    {
        return [
            'package_id' => \App\Models\Package::factory(),
            'transport_id' => \App\Models\Transport::factory(),
            'direction' => $this->faker->randomElement(['Outbound', 'Inbound', 'Internal']),
            'segment_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}