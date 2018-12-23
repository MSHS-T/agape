<?php

use Illuminate\Database\Seeder;

class ProjectCallsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_calls')->insert([
            "type" => 1,
            "year" => 2018,
            "title" => "Test titre 1",
            "description" => "Description",
            "application_start_date" => "2018-12-01",
            "application_end_date" => "2018-12-31",
            "evaluation_start_date" => "2019-01-01",
            "evaluation_end_date" => "2019-01-31",
            "number_of_experts" => 2,
            "number_of_documents" => 4,
            "privacy_clause" => "Clause",
            "invite_email_fr" => "Email FR",
            "invite_email_en" => "Email EN",
            "help_experts" => "Aide experts",
            "help_candidates" => "Aide candidats",
            "creator_id" => 1,
            "created_at" => "2018-12-17 11:22:54",
            "updated_at" => "2018-12-17 11:22:54"
        ]);
        DB::table('project_calls')->insert([
            "type" => 2,
            "year" => 2018,
            "title" => "Test titre 2",
            "description" => "Description",
            "application_start_date" => "2018-12-01",
            "application_end_date" => "2018-12-31",
            "evaluation_start_date" => "2019-01-01",
            "evaluation_end_date" => "2019-01-31",
            "number_of_experts" => 2,
            "number_of_documents" => 4,
            "privacy_clause" => "Clause",
            "invite_email_fr" => "Email FR",
            "invite_email_en" => "Email EN",
            "help_experts" => "Aide experts",
            "help_candidates" => "Aide candidats",
            "creator_id" => 1,
            "created_at" => "2018-12-17 11:22:54",
            "updated_at" => "2018-12-17 11:22:54"
        ]);
        DB::table('project_calls')->insert([
            "type" => 3,
            "year" => 2018,
            "title" => "Test titre 3",
            "description" => "Description",
            "application_start_date" => "2018-12-01",
            "application_end_date" => "2018-12-31",
            "evaluation_start_date" => "2019-01-01",
            "evaluation_end_date" => "2019-01-31",
            "number_of_experts" => 2,
            "number_of_documents" => 4,
            "privacy_clause" => "Clause",
            "invite_email_fr" => "Email FR",
            "invite_email_en" => "Email EN",
            "help_experts" => "Aide experts",
            "help_candidates" => "Aide candidats",
            "creator_id" => 1,
            "created_at" => "2018-12-17 11:22:54",
            "updated_at" => "2018-12-17 11:22:54"
        ]);
    }
}
