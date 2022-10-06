<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectCallTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_call_types')->insert(
            [
                'reference'   => 'RG',
                'label_long'  => 'Appel Coordonné MSHST-Région Occitanie',
                'label_short' => 'Appel Coordonné',
                'is_workshop' => false
            ]
        );
        DB::table('project_call_types')->insert(
            [
                'reference'   => 'EX',
                'label_long'  => 'AAP Exploratoire (APEX)',
                'label_short' => 'APEX',
                'is_workshop' => false
            ]
        );
        DB::table('project_call_types')->insert(
            [
                'reference'   => 'WS',
                'label_long'  => 'AAP Workshop',
                'label_short' => 'Workshop',
                'is_workshop' => true
            ]
        );
    }
}
