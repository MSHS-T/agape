<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [];
        foreach (config('agape.roles') as $roleName) {
            $roles[$roleName] = Role::firstOrCreate(['name' => $roleName]);
        }
        foreach (config('agape.permissions') as $permissionGroup => $permissions) {
            foreach ($permissions as $permissionName => $allowedRoles) {
                $p = Permission::firstOrCreate([
                    'name' => implode('.', [$permissionGroup, $permissionName]),
                ]);
                if (!empty($allowedRoles)) {
                    $p->syncRoles(
                        array_map(fn ($r) => $roles[$r], $allowedRoles)
                    );
                }
            }
        }
    }
}
