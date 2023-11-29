<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name'            => 'Gestionnaire',
            'last_name'             => 'AGAPE',
            'email'                 => 'gestionnaire@agape.fr',
            'email_verified_at'     => Carbon::now(),
            'password'              => Hash::make('password'),
        ])->assignRole('manager');

        User::create([
            'first_name'            => 'Expert',
            'last_name'             => 'AGAPE',
            'email'                 => 'expert@agape.fr',
            'email_verified_at'     => Carbon::now(),
            'password'              => Hash::make('password'),
        ])->assignRole('expert');

        User::create([
            'first_name'            => 'Candidat',
            'last_name'             => 'AGAPE',
            'email'                 => 'candidat@agape.fr',
            'email_verified_at'     => Carbon::now(),
            'password'              => Hash::make('password'),
        ])->assignRole('applicant');

        $this->call([
            ProjectCallTypeSeeder::class,
            StudyFieldSeeder::class,
            LaboratorySeeder::class,
            ProjectCallSeeder::class,
        ]);
    }
}
