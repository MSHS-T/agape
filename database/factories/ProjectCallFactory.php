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
        $applicationStart = new Carbon(fake()->dateTimeBetween('now', '+3 months'));

        return [
            'project_call_type_id'   => ProjectCallType::all()->pluck('id')->random(),
            'year'                   => $applicationStart->format('Y'),
            'title'                  => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->words(3, true)])->toArray(),
            'description'            => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)])->toArray(),
            'application_start_date' => $applicationStart,
            'application_end_date'   => $applicationStart->copy()->addMonths(1),
            'evaluation_start_date'  => $applicationStart->copy()->addMonths(2),
            'evaluation_end_date'    => $applicationStart->copy()->addMonths(3),
            'privacy_clause'         => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)])->toArray(),
            'invite_email'           => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)])->toArray(),
            'help_experts'           => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)])->toArray(),
            'help_candidates'        => collect(config('agape.languages'))->mapWithKeys(fn ($lang) => [$lang => $this->faker->sentences(3, true)])->toArray(),
            'notation'               => $generalSettings->notation,
            'creator_id'             => User::role('administrator')->first()->id,
            'extra_attributes'       => [
                'number_of_documents'    => $generalSettings->defaultNumberOfDocuments,
                'number_of_laboratories' => $generalSettings->defaultNumberOfLaboratories,
                'number_of_study_fields' => $generalSettings->defaultNumberOfStudyFields,
                'number_of_keywords'     => $generalSettings->defaultNumberOfKeywords,
            ],
        ];
    }
}
