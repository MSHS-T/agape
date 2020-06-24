<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Enums\UserRole;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Marie',
            'last_name' => 'CANDIDAT',
            'email' => 'marie.candidat@3rgo.tech',
            'email_verified_at' => '2019-04-19 11:30',
            'role' => UserRole::Candidate,
            'password' => bcrypt('candidat'),
            'created_at' => '2019-04-19 11:30',
            'updated_at' => '2019-04-19 11:30'
        ]);
        DB::table('users')->insert([
            'first_name' => 'Louise',
            'last_name' => 'CANDIDAT',
            'email' => 'louise.candidat@3rgo.tech',
            'email_verified_at' => '2019-04-19 11:30',
            'role' => UserRole::Candidate,
            'password' => bcrypt('candidat'),
            'created_at' => '2019-04-19 11:30',
            'updated_at' => '2019-04-19 11:30'
        ]);
        DB::table('users')->insert([
            'first_name' => 'Adèle',
            'last_name' => 'CANDIDAT',
            'email' => 'adele.candidat@3rgo.tech',
            'email_verified_at' => '2019-04-19 11:30',
            'role' => UserRole::Candidate,
            'password' => bcrypt('candidat'),
            'created_at' => '2019-04-19 11:30',
            'updated_at' => '2019-04-19 11:30'
        ]);
        DB::table('users')->insert([
            'first_name' => 'Nicolas',
            'last_name' => 'CANDIDAT',
            'email' => 'nicolas.candidat@3rgo.tech',
            'email_verified_at' => '2019-04-19 11:30',
            'role' => UserRole::Candidate,
            'password' => bcrypt('candidat'),
            'created_at' => '2019-04-19 11:30',
            'updated_at' => '2019-04-19 11:30'
        ]);
        DB::table('users')->insert([
            'first_name' => 'Jean',
            'last_name' => 'CANDIDAT',
            'email' => 'jean.candidat@3rgo.tech',
            'email_verified_at' => '2019-04-19 11:30',
            'role' => UserRole::Candidate,
            'password' => bcrypt('candidat'),
            'created_at' => '2019-04-19 11:30',
            'updated_at' => '2019-04-19 11:30'
        ]);
        DB::table('users')->insert([
            'first_name' => 'Jérémy',
            'last_name' => 'CANDIDAT',
            'email' => 'jeremy.candidat@3rgo.tech',
            'email_verified_at' => '2019-04-19 11:30',
            'role' => UserRole::Candidate,
            'password' => bcrypt('candidat'),
            'created_at' => '2019-04-19 11:30',
            'updated_at' => '2019-04-19 11:30'
        ]);

        DB::table('users')->insert([
            'first_name' => 'Julie',
            'last_name' => 'EXPERT',
            'email' => 'julie.expert@3rgo.tech',
            'email_verified_at' => '2019-04-19 11:30',
            'role' => UserRole::Expert,
            'password' => bcrypt('expert'),
            'created_at' => '2019-04-19 11:30',
            'updated_at' => '2019-04-19 11:30'
        ]);
        DB::table('users')->insert([
            'first_name' => 'Caroline',
            'last_name' => 'EXPERT',
            'email' => 'caroline.expert@3rgo.tech',
            'email_verified_at' => '2019-04-19 11:30',
            'role' => UserRole::Expert,
            'password' => bcrypt('expert'),
            'created_at' => '2019-04-19 11:30',
            'updated_at' => '2019-04-19 11:30'
        ]);
        DB::table('users')->insert([
            'first_name' => 'Sandra',
            'last_name' => 'EXPERT',
            'email' => 'sandra.expert@3rgo.tech',
            'email_verified_at' => '2019-04-19 11:30',
            'role' => UserRole::Expert,
            'password' => bcrypt('expert'),
            'created_at' => '2019-04-19 11:30',
            'updated_at' => '2019-04-19 11:30'
        ]);
        DB::table('users')->insert([
            'first_name' => 'Guillaume',
            'last_name' => 'EXPERT',
            'email' => 'guillaume.expert@3rgo.tech',
            'email_verified_at' => '2019-04-19 11:30',
            'role' => UserRole::Expert,
            'password' => bcrypt('expert'),
            'created_at' => '2019-04-19 11:30',
            'updated_at' => '2019-04-19 11:30'
        ]);
        DB::table('users')->insert([
            'first_name' => 'Marc',
            'last_name' => 'EXPERT',
            'email' => 'marc.expert@3rgo.tech',
            'email_verified_at' => '2019-04-19 11:30',
            'role' => UserRole::Expert,
            'password' => bcrypt('expert'),
            'created_at' => '2019-04-19 11:30',
            'updated_at' => '2019-04-19 11:30'
        ]);
        DB::table('users')->insert([
            'first_name' => 'Thomas',
            'last_name' => 'EXPERT',
            'email' => 'thomas.expert@3rgo.tech',
            'email_verified_at' => '2019-04-19 11:30',
            'role' => UserRole::Expert,
            'password' => bcrypt('expert'),
            'created_at' => '2019-04-19 11:30',
            'updated_at' => '2019-04-19 11:30'
        ]);
    }
}
