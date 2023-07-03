<?php

namespace Database\Factories;

use App\Helpers\Faker\Factory\DhivehiFactory;
use App\Models\Legislation;
use Illuminate\Database\Eloquent\Factories\Factory;

class LegislationFactory extends DhivehiFactory
{
    protected $model = Legislation::class;

    public function definition(): array
    {
        return [
            'title'       => $this->dhivehi_faker->words(5),
            'description' => $this->dhivehi_faker->words(10),
        ];
    }
}
