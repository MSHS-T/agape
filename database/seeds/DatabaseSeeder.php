<?php

use Illuminate\Database\Seeder;

use App\Enums\UserRole;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Insert admin user
        DB::table('users')->insert([
            'first_name' => 'Administrateur',
            'last_name' => 'AGAPE',
            'email' => 'romain@3rgo.tech',
            'role' => UserRole::Admin,
            'password' => bcrypt('admin'),
        ]);

        $this->call(SettingsTableSeeder::class);
        $this->call(ProjectCallsTableSeeder::class);
    }
}
