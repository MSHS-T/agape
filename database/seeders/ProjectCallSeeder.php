<?php

namespace Database\Seeders;

use App\Models\ProjectCall;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectCallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectCall::factory()->count(5)->create();
    }
}
