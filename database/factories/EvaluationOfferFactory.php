<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EvaluationOffer;
use App\Models\Invitation;
use App\Models\User;

class EvaluationOfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EvaluationOffer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // TODO : review the factory
        return [
            'accepted' => $this->faker->boolean,
            'justification' => $this->faker->text,
            'extra_attributes' => '{}',
            'creator_id' => User::factory(),
            'expert_id' => User::factory(),
            'invitation_id' => Invitation::factory(),
        ];
    }
}
