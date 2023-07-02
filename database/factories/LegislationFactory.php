<?php

namespace Database\Factories;

use App\Models\Legislation;
use Illuminate\Database\Eloquent\Factories\Factory;

class LegislationFactory extends Factory
{
    protected $model = Legislation::class;

    public function definition(): array
    {
        return [
            'title'       => $this->faker->words(5, true),
            'description' => $this->faker->text(),
        ];
    }
}
