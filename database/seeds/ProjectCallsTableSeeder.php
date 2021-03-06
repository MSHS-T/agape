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
            "reference" => "18-RG-01",
            "title" => "Test titre archivé",
            "description" => "Description",
            "application_start_date" => "2018-11-01",
            "application_end_date" => "2018-11-30",
            "evaluation_start_date" => "2018-12-01",
            "evaluation_end_date" => "2018-12-31",
            "number_of_experts" => 2,
            "number_of_documents" => 4,
            "number_of_keywords" => 5,
            "number_of_laboratories" => 4,
            "number_of_study_fields" => 3,
            "number_of_target_dates" => 5,
            "privacy_clause" => "Clause",
            "invite_email_fr" => "Email FR",
            "invite_email_en" => "Email EN",
            "help_experts" => "Aide experts",
            "help_candidates" => "Aide candidats",
            "creator_id" => 1,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
            "deleted_at" => "2019-01-01 12:00:00"
        ]);
        DB::table('project_calls')->insert([
            "type" => 1,
            "year" => 2019,
            "reference" => "19-RG-01",
            "title" => "Test titre 1",
            "description" => "Description",
            "application_start_date" => "2019-03-01",
            "application_end_date" => "2019-03-28",
            "evaluation_start_date" => "2019-04-01",
            "evaluation_end_date" => "2019-04-28",
            "number_of_experts" => 2,
            "number_of_documents" => 4,
            "number_of_keywords" => 5,
            "number_of_laboratories" => 4,
            "number_of_study_fields" => 3,
            "number_of_target_dates" => 5,
            "privacy_clause" => "Clause",
            "invite_email_fr" => "Email FR",
            "invite_email_en" => "Email EN",
            "help_experts" => "Aide experts",
            "help_candidates" => "Aide candidats",
            "creator_id" => 1,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ]);
        DB::table('project_calls')->insert([
            "type" => 2,
            "year" => 2019,
            "reference" => "19-EX-01",
            "title" => "Test titre 2",
            "description" => "Description",
            "application_start_date" => "2019-03-01",
            "application_end_date" => "2019-03-28",
            "evaluation_start_date" => "2019-04-01",
            "evaluation_end_date" => "2019-04-28",
            "number_of_experts" => 2,
            "number_of_documents" => 4,
            "number_of_keywords" => 5,
            "number_of_laboratories" => 4,
            "number_of_study_fields" => 3,
            "number_of_target_dates" => 5,
            "privacy_clause" => "Clause",
            "invite_email_fr" => "Email FR",
            "invite_email_en" => "Email EN",
            "help_experts" => "Aide experts",
            "help_candidates" => "Aide candidats",
            "creator_id" => 1,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ]);
        DB::table('project_calls')->insert([
            "type" => 3,
            "year" => 2019,
            "reference" => "19-WS-01",
            "title" => "Test titre 3",
            "description" => "Description",
            "application_start_date" => "2019-03-01",
            "application_end_date" => "2019-03-28",
            "evaluation_start_date" => "2019-04-01",
            "evaluation_end_date" => "2019-04-28",
            "number_of_experts" => 2,
            "number_of_documents" => 4,
            "number_of_keywords" => 5,
            "number_of_laboratories" => 4,
            "number_of_study_fields" => 3,
            "number_of_target_dates" => 5,
            "privacy_clause" => "Clause",
            "invite_email_fr" => "Email FR",
            "invite_email_en" => "Email EN",
            "help_experts" => "Aide experts",
            "help_candidates" => "Aide candidats",
            "creator_id" => 1,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ]);
    }
}
