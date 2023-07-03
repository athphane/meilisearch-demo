<?php

namespace Database\Factories;

use App\Helpers\Faker\Factory\DhivehiFactory;
use App\Models\Section;

class SectionFactory extends DhivehiFactory
{
    protected $model = Section::class;

    public function definition(): array
    {
        return [
            'title' => $this->dhivehi_faker->words(3),
            'text'  => $this->dhivehi_faker->words(30),
        ];
    }
}
