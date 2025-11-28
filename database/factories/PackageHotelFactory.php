<?php

namespace Database\Factories;

use App\Models\PackageHotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageHotelFactory extends Factory
{
    protected $model = PackageHotel::class;

    public function definition(): array
    {
        return [
            'package_id' => \App\Models\Package::factory(),
            'hotel_id' => \App\Models\Hotel::factory(),
            'city' => $this->faker->city(),
            'nights' => $this->faker->numberBetween(1, 10),
        ];
    }
}