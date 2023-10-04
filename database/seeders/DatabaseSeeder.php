<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->write(
            Task::class,
            'Creating roles and permissions',
            function () {
                $this->run([
                    RolesPermissionsSeeder::class
                ]);
            }
        );

        $this->write(
            Task::class,
            'Creating users',
            function () {
                User::create([
                    'first_name'            => 'Administrateur',
                    'last_name'             => 'AGAPE',
                    'email'                 => 'admin@univ-tlse2.fr',
                    'email_verified_at'     => Carbon::now(),
                    'password'              => Hash::make('password'),
                ])->assignRole('administrator');

                User::create([
                    'first_name'            => 'Gestionnaire',
                    'last_name'             => 'AGAPE',
                    'email'                 => 'gestionnaire@univ-tlse2.fr',
                    'email_verified_at'     => Carbon::now(),
                    'password'              => Hash::make('password'),
                ])->assignRole('manager');

                User::create([
                    'first_name'            => 'Expert',
                    'last_name'             => 'AGAPE',
                    'email'                 => 'expert@univ-tlse2.fr',
                    'email_verified_at'     => Carbon::now(),
                    'password'              => Hash::make('password'),
                ])->assignRole('expert');

                User::create([
                    'first_name'            => 'Candidat',
                    'last_name'             => 'AGAPE',
                    'email'                 => 'candidat@univ-tlse2.fr',
                    'email_verified_at'     => Carbon::now(),
                    'password'              => Hash::make('password'),
                ])->assignRole('applicant');
            }
        );
    }

    /**
     * Write to the console's output.
     *
     * @param  string  $component
     * @param  array<int, string>|string  $arguments
     * @return void
     */
    protected function write($component, ...$arguments)
    {
        if ($this->command->getOutput() && class_exists($component)) {
            (new $component($this->command->getOutput()))->render(...$arguments);
        } else {
            foreach ($arguments as $argument) {
                if (is_callable($argument)) {
                    $argument();
                }
            }
        }
    }
}
