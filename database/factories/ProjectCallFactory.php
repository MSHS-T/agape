<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ProjectCall;
use App\Models\User;

class ProjectCallFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectCall::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // TODO : review the factory
        return [
            'reference' => $this->faker->word,
            'year' => $this->faker->word,
            'title' => '{}',
            'description' => '{}',
            'application_start_date' => $this->faker->date(),
            'application_end_date' => $this->faker->date(),
            'evaluation_start_date' => $this->faker->date(),
            'evaluation_end_date' => $this->faker->date(),
            'privacy_clause' => '{}',
            'invite_email' => '{}',
            'help_experts' => '{}',
            'help_candidates' => '{}',
            'devalidation_message' => $this->faker->word,
            'notation_1_title' => '{}',
            'notation_1_description' => '{}',
            'notation_2_title' => '{}',
            'notation_2_description' => '{}',
            'notation_3_title' => '{}',
            'notation_3_description' => '{}',
            'extra_attributes' => '{}',
            'creator_id' => User::factory(),
        ];
    }

    /**
     * Indicate that the model's extra attributes should be those of a generic project call
     */
    public function generic(): static
    {
        $dates = [];
        foreach (range(1, 3) as $i) {
            $dates[] = fake()->dateTimeBetween('now', '+6 months')->format('Y-m-d');
        }
        return $this->state(function (array $attributes) use ($dates) {
            return [
                'extra_attributes' => array_merge(
                    $attributes['extra_attributes'],
                    ['target_date' => $dates]
                ),
            ];
        });
    }

    /**
     * Indicate that the model's extra attributes should be those of a workshop project call
     */
    public function workshop(): static
    {
        $dates = [];
        foreach (range(1, 3) as $i) {
            $dates[] = fake()->dateTimeBetween('now', '+6 months')->format('Y-m-d');
        }
        return $this->state(function (array $attributes) use ($dates) {
            return [
                'extra_attributes' => array_merge(
                    $attributes['extra_attributes'],
                    ['target_date' => $dates]
                ),
            ];
        });
    }
}
