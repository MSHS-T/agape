<?php

namespace Tests\Unit;

use App\Models\ProjectCall;
use App\Models\ProjectCallType;
use App\Models\User;
use Database\Seeders\RolesPermissionsSeeder;
use Tests\CreatesApplication;
use Tests\TestCase;

class ApplicationReferenceTest extends TestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesPermissionsSeeder::class);
        $this->actingAs($user = User::factory()->create()->assignRole('administrator'));
    }

    /**
     * A basic test example.
     */
    public function test_that_application_references_are_generated_properly(): void
    {
        $projectCallType = ProjectCallType::factory()->create();
        $projectCall = ProjectCall::factory([
            'project_call_type_id' => $projectCallType->id
        ])->application()
            ->create();

        $application = $projectCall->applications()->create([
            'title' => fake()->sentence(4)
        ]);

        $this->assertEquals($application->reference, $projectCall->reference . '-001');

        $application = $projectCall->applications()->create([
            'title' => fake()->sentence(4)
        ]);

        $this->assertEquals($application->reference, $projectCall->reference . '-002');

        $application = $projectCall->applications()->create([
            'title' => fake()->sentence(4)
        ]);

        $this->assertEquals($application->reference, $projectCall->reference . '-003');
    }
    /**
     * A basic test example.
     */
    public function test_that_application_references_are_generated_properly_when_call_reference_contains_dashes(): void
    {
        $projectCallType = ProjectCallType::factory([
            'reference' => 'AAA-BBB-CCC-DDD'
        ])->create();
        $projectCall = ProjectCall::factory([
            'project_call_type_id' => $projectCallType->id
        ])->application()
            ->create();

        $application = $projectCall->applications()->create([
            'title' => fake()->sentence(4)
        ]);

        ray($application->reference);

        $this->assertEquals($application->reference, $projectCall->reference . '-001');

        $application = $projectCall->applications()->create([
            'title' => fake()->sentence(4)
        ]);

        $this->assertEquals($application->reference, $projectCall->reference . '-002');

        $application = $projectCall->applications()->create([
            'title' => fake()->sentence(4)
        ]);

        $this->assertEquals($application->reference, $projectCall->reference . '-003');
    }
}
