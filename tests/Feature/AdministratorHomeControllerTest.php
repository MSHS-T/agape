<?php

use App\Models\User;
use Database\Seeders\RolesPermissionsSeeder;

beforeEach(function () {
    $this->seed(RolesPermissionsSeeder::class);
});

test('admins are redirected to filament from home', function () {
    $user = User::factory()->create()->assignRole('administrator');
    test()->actingAs($user)
        ->get('/')
        ->assertRedirect(route('filament.admin.pages.dashboard'));
});
