<?php

namespace Database\Factories;

use App\Models\Relationship;
use Illuminate\Database\Eloquent\Factories\Factory;

class RelationshipFactory extends Factory
{
    protected $model = Relationship::class;

    public function definition(): array
    {
        return [
            'pilgrim_a_id' => \App\Models\Pilgrim::factory(),
            'pilgrim_b_id' => \App\Models\Pilgrim::factory(),
            'relationType' => $this->faker->randomElement(['Family', 'Friend', 'Spouse', 'Parent', 'Child']),
        ];
    }
}