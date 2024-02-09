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
        foreach (range(1, 3) as $i) {
            User::create([
                'first_name'            => "Gestionnaire $i",
                'last_name'             => 'AGAPE',
                'email'                 => "gestionnaire{$i}@agape.fr",
                'email_verified_at'     => Carbon::now(),
                'password'              => Hash::make('password'),
            ])->assignRole('manager');
        }

        foreach (range(1, 10) as $i) {
            User::create([
                'first_name'            => "Expert $i",
                'last_name'             => 'AGAPE',
                'email'                 => "expert{$i}@agape.fr",
                'email_verified_at'     => Carbon::now(),
                'password'              => Hash::make('password'),
            ])->assignRole('expert');
        }

        foreach (range(1, 10) as $i) {
            User::create([
                'first_name'            => "Candidat $i",
                'last_name'             => 'AGAPE',
                'email'                 => "candidat{$i}@agape.fr",
                'email_verified_at'     => Carbon::now(),
                'password'              => Hash::make('password'),
            ])->assignRole('applicant');
        }

        $this->call([
            ProjectCallTypeSeeder::class,
            StudyFieldSeeder::class,
            LaboratorySeeder::class,
            ProjectCallSeeder::class,
        ]);
    }
}
