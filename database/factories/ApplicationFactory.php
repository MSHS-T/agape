<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Application;
use App\Models\User;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // TODO : review the factory
        return [
            'title' => $this->faker->sentence(4),
            'acronym' => $this->faker->word,
            'theme' => $this->faker->text,
            'short_description' => $this->faker->text,
            'summary' => '{}',
            'keywords' => '{}',
            'other_laboratories' => $this->faker->text,
            'amount_requested' => $this->faker->randomFloat(0, 0, 9999999999.),
            'other_fundings' => $this->faker->randomFloat(0, 0, 9999999999.),
            'total_expected_income' => $this->faker->randomFloat(0, 0, 9999999999.),
            'total_expected_outcome' => $this->faker->randomFloat(0, 0, 9999999999.),
            'selection_comity_opinion' => $this->faker->text,
            'devalidation_message' => $this->faker->word,
            'extra_attributes' => '{}',
            'applicant_id' => User::factory(),
            'submitted_at' => $this->faker->dateTime(),
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
