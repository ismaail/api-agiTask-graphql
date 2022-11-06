<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Domain\Board\Models\Board;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class BoardFactory
 * @package Database\Factories
 */
class BoardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Board::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => Str::title($this->faker->words(3, true)),
            'description' => $this->faker->sentence(20),
            'archived' => false,
        ];
    }
}
