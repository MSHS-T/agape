<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Evaluation;

class EvaluationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Evaluation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'grade1'         => fake()->numberBetween(0, 3),
            'grade2'         => fake()->numberBetween(0, 3),
            'grade3'         => fake()->numberBetween(0, 3),
            'global_grade'   => fake()->numberBetween(0, 3),
            'comment1'       => fake()->realText(),
            'comment2'       => fake()->realText(),
            'comment3'       => fake()->realText(),
            'global_comment' => fake()->realText(),
        ];
    }
}
