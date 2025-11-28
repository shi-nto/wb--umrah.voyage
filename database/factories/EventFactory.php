<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $departDate = $this->faker->dateTimeBetween('now', '+1 year');
        $returnDate = $this->faker->dateTimeBetween($departDate, $departDate->format('Y-m-d H:i:s') . ' +2 weeks');

        return [
            'code' => strtoupper($this->faker->lexify('???_??/?? - ??/??_??? ??? ???')),
            'departDate' => $departDate,
            'returnDate' => $returnDate,
            'departCity' => $this->faker->city(),
            'destinations' => implode(', ', $this->faker->randomElements(['JED', 'MAD', 'MEI', 'BAH'], $this->faker->numberBetween(1, 4))),
            'description' => $this->faker->sentence(),
        ];
    }
}