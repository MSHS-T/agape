<?php

namespace Tests\Feature;

use App\Models\ProjectCall;
use App\Models\ProjectCallType;
use App\Models\User;
use Database\Seeders\RolesPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicantHomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_applicants_are_shown_the_correct_project_calls(): void
    {
        $this->seed(RolesPermissionsSeeder::class);
        $this->actingAs($user = User::factory()->create()->assignRole('applicant'));

        ProjectCallType::factory()->create();
        $pc1 = ProjectCall::factory()->planned()->create();
        $pc2 = ProjectCall::factory()->application()->create();
        $pc3 = ProjectCall::factory()->betweenApplicationAndEvaluation()->create();
        $pc4 = ProjectCall::factory()->evaluation()->create();
        $pc5 = ProjectCall::factory()->finished()->create();
        $pc6 = ProjectCall::factory()->archived()->create();

        $response = $this->get('/');
        $response->assertRedirect(route('filament.applicant.pages.dashboard'));

        $response = $this->followRedirects($response);
        $this->assertEquals(1, substr_count($response->content(), 'projectcall-card-candidate'));

        $this->assertStringContainsString('projectcall-' . md5($pc2->id), $response->content());
        $this->assertStringNotContainsString('projectcall-' . md5($pc1->id), $response->content());
        $this->assertStringNotContainsString('projectcall-' . md5($pc3->id), $response->content());
        $this->assertStringNotContainsString('projectcall-' . md5($pc4->id), $response->content());
        $this->assertStringNotContainsString('projectcall-' . md5($pc5->id), $response->content());
        $this->assertStringNotContainsString('projectcall-' . md5($pc6->id), $response->content());
    }

    // TODO : test project call buttons depending on application existence
}
