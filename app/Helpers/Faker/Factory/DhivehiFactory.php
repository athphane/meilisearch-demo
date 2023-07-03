<?php


namespace App\Helpers\Faker\Factory;


use App\Helpers\Faker\DhivehiContentBlock;
use App\Helpers\Faker\DhivehiFaker;
use App\Helpers\Faker\EnglishContentBlock;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

abstract class DhivehiFactory extends Factory
{
    /**
     * @var DhivehiFaker
     */
    public $dhivehi_faker;

    public function __construct($count = null, ?Collection $states = null, ?Collection $has = null, ?Collection $for = null, ?Collection $afterMaking = null, ?Collection $afterCreating = null, $connection = null)
    {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection);
        $this->dhivehi_faker = new DhivehiFaker();
    }

    abstract function definition();

    public function getContentBlock()
    {
        return (new DhivehiContentBlock(true))->get();
    }

    public function getLiteContentBlock()
    {
        return (new DhivehiContentBlock(true, true))->get();
    }

    public function getEnglishContentBlock()
    {
        return (new EnglishContentBlock($this->faker, true))->get();
    }
}
