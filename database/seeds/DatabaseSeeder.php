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
            'email_verified_at' => '2018-12-14 12:00:00',
            'role' => UserRole::Admin,
            'password' => bcrypt('admin'),
        ]);
        // Insert candidate user
        DB::table('users')->insert([
            'first_name' => 'Candidat',
            'last_name' => 'AGAPE',
            'email' => 'candidat@3rgo.tech',
            'email_verified_at' => '2018-12-14 12:00:00',
            'role' => UserRole::Candidate,
            'password' => bcrypt('candidat'),
        ]);

        $this->call(SettingsTableSeeder::class);
        $this->call(ProjectCallsTableSeeder::class);
        $this->call(PersonsTableSeeder::class);
        $this->call(StudyFieldsTableSeeder::class);
    }
}
