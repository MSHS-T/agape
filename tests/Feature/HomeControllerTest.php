<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolesPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_admins_are_redirected_to_filament_from_home(): void
    {
        $this->seed(RolesPermissionsSeeder::class);
        $this->actingAs($user = User::factory()->create()->assignRole('administrator'));
        $response = $this->get('/');

        $response->assertRedirect(route('filament.admin.pages.dashboard'));
    }
}
