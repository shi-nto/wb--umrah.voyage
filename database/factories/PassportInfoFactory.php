<?php

namespace Database\Factories;

use App\Models\PassportInfo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PassportInfoFactory extends Factory
{
    protected $model = PassportInfo::class;

    public function definition(): array
    {
        return [
            'pilgrim_id' => \App\Models\Pilgrim::factory(),
            'numeroPasseport' => strtoupper($this->faker->bothify('??#######')),
            'dateDelivrance' => Carbon::now()->subYears($this->faker->numberBetween(0, 5)),
            'dateExpiration' => Carbon::now()->addYears($this->faker->numberBetween(5, 10)),
        ];
    }
}