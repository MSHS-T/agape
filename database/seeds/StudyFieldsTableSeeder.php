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
            ['name' => 'Ingénierie', 'creator_id' => 1],
            ['name' => 'Biologie', 'creator_id' => 1],
            ['name' => 'Aéronautique', 'creator_id' => 1],
            ['name' => 'Spatial', 'creator_id' => 1],
            ['name' => 'Chimie', 'creator_id' => 1],
            ['name' => 'Sciences Humaines', 'creator_id' => 1],
            ['name' => 'Sciences Sociales', 'creator_id' => 1],
            ['name' => 'Économie', 'creator_id' => 1]
        ]);
    }
}
