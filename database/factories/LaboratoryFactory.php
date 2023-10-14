<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Laboratory;
use App\Models\User;

class LaboratoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Laboratory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name'           => fake()->words(3, true),
            'unit_code'      => fake()->bothify('?? ####'),
            'director_email' => fake()->safeEmail(),
            'regency'        => fake()->word(),
            'creator_id'     => null,
        ];
    }
}
