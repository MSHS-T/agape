<?php

use Illuminate\Database\Seeder;

class StudyFieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('study_fields')->insert([
            ['name' => 'Ingénierie'],
            ['name' => 'Biologie'],
            ['name' => 'Aéronautique'],
            ['name' => 'Spatial'],
            ['name' => 'Chimie'],
            ['name' => 'Sciences Humaines'],
            ['name' => 'Sciences Sociales'],
            ['name' => 'Économie']
        ]);
    }
}
