<?php

namespace Database\Factories;

use App\Models\Alert;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlertFactory extends Factory
{
    protected $model = Alert::class;

    public function definition(): array
    {
        return [
            'pilgrim_id' => \App\Models\Pilgrim::factory(),
            'type' => $this->faker->randomElement(['Health', 'Payment', 'Travel', 'Booking Confirmed', 'Invalid Passport', 'Payment Reminder']),
            'message' => $this->faker->sentence(),
        ];
    }
}