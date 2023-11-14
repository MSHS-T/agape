<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ProjectCall;
use App\Models\User;
use App\Settings\GeneralSettings;
use Illuminate\Support\Carbon;

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
        $applicationStart = new Carbon(fake()->dateTimeBetween('now', '+3 months'));
        return [
            'reference'              => $this->faker->word,
            'year'                   => $this->faker->word,
            'title'                  => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->words(3, true)]),
            'description'            => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)]),
            'application_start_date' => $applicationStart,
            'application_end_date'   => $applicationStart->copy()->addMonths(1),
            'evaluation_start_date'  => $applicationStart->copy()->addMonths(2),
            'evaluation_end_date'    => $applicationStart->copy()->addMonths(3),
            'privacy_clause'         => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)]),
            'invite_email'           => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)]),
            'help_experts'           => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)]),
            'help_candidates'        => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)]),
            'devalidation_message'   => $this->faker->word,
            'notation'               => app(GeneralSettings::class)->notation,
            'extra_attributes'       => '{}',
            'creator_id'             => User::factory(),
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
