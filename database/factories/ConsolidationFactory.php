<?php

namespace Database\Factories;

use App\Models\Consolidation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsolidationFactory extends Factory
{
    protected $model = Consolidation::class;

    public function definition(): array
    {
        return [
            'title'       => $this->faker->word(),
            'description' => $this->faker->text(),
        ];
    }
}
