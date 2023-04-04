<?php

namespace Database\Factories\Bucket;

use Domain\Bucket\Models\Bucket;
use Illuminate\Database\Eloquent\Factories\Factory;

class BucketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Bucket::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(),
        ];
    }
}
