<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\StudyField;
use App\Models\User;

class StudyFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudyField::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name'       => ['fr' => fake()->words(3, true), 'en' => fake('en_GB')->words(3, true)],
            'creator_id' => null,
        ];
    }
}
