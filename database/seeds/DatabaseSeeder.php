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
            'email' => 'daniele.dattas@univ-tlse2.fr',
            'email_verified_at' => '2019-04-19 11:00',
            'role' => UserRole::Admin,
            'password' => bcrypt('admin'),
            'created_at' => '2019-04-19 11:00',
            'updated_at' => '2019-04-19 11:00'
        ]);

        $this->call(SettingsTableSeeder::class);
    }
}
