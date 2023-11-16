<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ProjectCall;
use App\Models\ProjectCallType;
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
        $generalSettings = app(GeneralSettings::class);
        $applicationStart = new Carbon(fake()->dateTimeBetween('-1 month', '+1 months'));

        return [
            'project_call_type_id'   => ProjectCallType::all()->pluck('id')->random(),
            'year'                   => $applicationStart->format('Y'),
            'title'                  => fake()->boolean()
                ? collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->words(3, true)])->toArray()
                : array_fill_keys(config('agape.languages'), null),
            'description'            => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)])->toArray(),
            'application_start_date' => $applicationStart,
            'application_end_date'   => $applicationStart->copy()->addWeeks(2),
            'evaluation_start_date'  => $applicationStart->copy()->addWeeks(4),
            'evaluation_end_date'    => $applicationStart->copy()->addWeeks(6),
            'privacy_clause'         => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)])->toArray(),
            'invite_email'           => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)])->toArray(),
            'help_experts'           => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)])->toArray(),
            'help_candidates'        => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)])->toArray(),
            'notation'               => $generalSettings->notation,
            'creator_id'             => User::role('administrator')->first()?->id ?? null,
            'extra_attributes'       => [
                'number_of_documents'    => $generalSettings->defaultNumberOfDocuments,
                'number_of_laboratories' => $generalSettings->defaultNumberOfLaboratories,
                'number_of_study_fields' => $generalSettings->defaultNumberOfStudyFields,
                'number_of_keywords'     => $generalSettings->defaultNumberOfKeywords,
            ],
        ];
    }

    public function planned(): static
    {
        $applicationStart = new Carbon(fake()->dateTimeBetween('+3 days', '+1 month'));
        return $this->state(fn (array $attributes) => [
            'application_start_date' => $applicationStart,
            'application_end_date'   => $applicationStart->copy()->addWeeks(2),
            'evaluation_start_date'  => $applicationStart->copy()->addWeeks(4),
            'evaluation_end_date'    => $applicationStart->copy()->addWeeks(6),
        ]);
    }
    public function application(): static
    {
        $applicationStart = new Carbon(fake()->dateTimeBetween('-10 days', 'now'));
        return $this->state(fn (array $attributes) => [
            'application_start_date' => $applicationStart,
            'application_end_date'   => $applicationStart->copy()->addWeeks(2),
            'evaluation_start_date'  => $applicationStart->copy()->addWeeks(4),
            'evaluation_end_date'    => $applicationStart->copy()->addWeeks(6),
        ]);
    }
    public function betweenApplicationAndEvaluation(): static
    {
        $applicationStart = new Carbon(fake()->dateTimeBetween('-30 days', '-20 days'));
        return $this->state(fn (array $attributes) => [
            'application_start_date' => $applicationStart,
            'application_end_date'   => $applicationStart->copy()->addWeeks(2),
            'evaluation_start_date'  => $applicationStart->copy()->addWeeks(4),
            'evaluation_end_date'    => $applicationStart->copy()->addWeeks(6),
        ]);
    }
    public function evaluation(): static
    {
        $applicationStart = new Carbon(fake()->dateTimeBetween('-40 days', '-30 days'));
        return $this->state(fn (array $attributes) => [
            'application_start_date' => $applicationStart,
            'application_end_date'   => $applicationStart->copy()->addWeeks(2),
            'evaluation_start_date'  => $applicationStart->copy()->addWeeks(4),
            'evaluation_end_date'    => $applicationStart->copy()->addWeeks(6),
        ]);
    }
    public function finished(): static
    {
        $applicationStart = new Carbon(fake()->dateTimeBetween('-10 weeks', '-7 weeks'));
        return $this->state(fn (array $attributes) => [
            'application_start_date' => $applicationStart,
            'application_end_date'   => $applicationStart->copy()->addWeeks(2),
            'evaluation_start_date'  => $applicationStart->copy()->addWeeks(4),
            'evaluation_end_date'    => $applicationStart->copy()->addWeeks(6),
        ]);
    }
    public function archived(): static
    {
        $applicationStart = new Carbon(fake()->dateTimeBetween('-10 weeks', '-7 weeks'));
        return $this->state(fn (array $attributes) => [
            'application_start_date' => $applicationStart,
            'application_end_date'   => $applicationStart->copy()->addWeeks(2),
            'evaluation_start_date'  => $applicationStart->copy()->addWeeks(4),
            'evaluation_end_date'    => $applicationStart->copy()->addWeeks(6),
            'deleted_at'             => fake()->dateTimeBetween('-1 week', 'now'),
        ]);
    }
}
