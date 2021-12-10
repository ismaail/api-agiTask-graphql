<?php

namespace Database\Factories;

use App\Models\Bucket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class BucketFactory
 * @package Database\Factories
 */
class BucketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bucket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(),
        ];
    }
}
