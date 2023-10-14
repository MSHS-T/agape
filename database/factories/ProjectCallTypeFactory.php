<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ProjectCallType;

class ProjectCallTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectCallType::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $acronym = Str::upper(fake()->lexify('???'));
        return [
            'reference'        => $this->faker->word,
            'label_long'       => ['fr' => fake()->words(3, true), 'en' => fake('en_GB')->words(3, true)],
            'label_short'      => ['fr' => $acronym, 'en' => $acronym],
            'extra_attributes' => [],
        ];
    }

    /**
     * Indicate the type to include in the model's extra attributes
     */
    public function type(string $type): static
    {
        return $this->state(function (array $attributes) use ($type) {
            return [
                'extra_attributes' => array_merge(
                    $attributes['extra_attributes'],
                    ['type' => $type]
                ),
            ];
        });
    }
}
