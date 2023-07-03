<?php

namespace Database\Factories;

use App\Helpers\Faker\Factory\DhivehiFactory;
use App\Models\Consolidation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsolidationFactory extends DhivehiFactory
{
    protected $model = Consolidation::class;

    public function definition(): array
    {
        return [
            'title'       => $this->dhivehi_faker->words(2),
            'description' => $this->dhivehi_faker->words(10),
        ];
    }
}
