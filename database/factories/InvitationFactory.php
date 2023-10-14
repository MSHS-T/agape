<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Invitation;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class InvitationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invitation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'invitation'       => Str::random(32),
            'email'            => fake()->safeEmail,
            'extra_attributes' => [],
        ];
    }

    public function role(string $role): static
    {
        return $this->state(function (array $attributes) use ($role) {
            return [
                'extra_attributes' => array_merge(
                    $attributes['extra_attributes'],
                    ['role' => $role]
                )
            ];
        });
    }
}
