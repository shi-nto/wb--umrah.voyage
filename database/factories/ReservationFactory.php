<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Pilgrim;
use App\Models\Package;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        return [
            'pilgrim_id' => Pilgrim::factory(),
            'package_id' => Package::factory(),
            'room_id' => Room::factory(),
            'totalPrix' => $this->faker->randomFloat(2, 5000, 20000),
            'montantPaye' => $this->faker->randomFloat(2, 1000, 20000),
            'selectionne' => $this->faker->boolean(),
        ];
    }
}
