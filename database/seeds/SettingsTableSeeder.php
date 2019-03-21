<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'key' => 'max_number_of_target_dates',
            'value' => 4
        ]);
        DB::table('settings')->insert([
            'key' => 'max_number_of_experts',
            'value' => 4
        ]);
        DB::table('settings')->insert([
            'key' => 'max_number_of_documents',
            'value' => 10
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_grid',
            'value' => json_encode([
                0 => [
                    "grade" => "C",
                    "details" => "Projet à conforter"
                ],
                1 => [
                    "grade" => "B",
                    "details" => "Bon projet"
                ],
                2 => [
                    "grade" => "A",
                    "details" => "Très bon projet"
                ],
                3 => [
                    "grade" => "A+",
                    "details" => "Excellent projet"
                ],
            ])
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_1_title',
            'value' => 'Qualité et ambition scientifique du projet'
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_2_title',
            'value' => 'Organisation du projet et moyens mis en oeuvre'
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_3_title',
            'value' => 'Impact et retombées du projet'
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_1_description',
            'value' => '<ul><li>Clarté des objectifs et des hypothèses de recherche</li><li>Caractère interdisciplinaire du projet et effet structurant</li><li>Caractère novateur, originalité, progrès par rapport à l\'état de l\'art</li><li>Faisabilité notamment au regard des méthodes, gestion des risques scientifiques</li></ul>'
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_2_description',
            'value' => '<ul><li>Compétence, expertise et implication du coordinateur scientique et des partenaires</li><li>Qualité et complémentarité de l\'équipe, qualité de la collaboration</li><li>Adéquation aux objectifs des moyens mis en oeuvre et demandés (cohérence du projet)</li></ul>'
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_3_description',
            'value' => '<ul><li>Impact scientifique, social, économique ou culturel</li><li>Capacité du projet à répondre aux enjeux de recherche, acquisitions de nouvelles connaissances et de savoir-faire</li><li>Stratégie de diffusion et de valorisation des résultats</li></ul>'
        ]);
        DB::table('settings')->insert([
            'key' => 'max_number_of_laboratories',
            'value' => 4
        ]);
        DB::table('settings')->insert([
            'key' => 'max_number_of_study_fields',
            'value' => 3
        ]);
        DB::table('settings')->insert([
            'key' => 'max_number_of_keywords',
            'value' => 5
        ]);
        DB::table('settings')->insert([
            'key' => 'extensions_application_form',
            'value' => '.xls,.xlsx,.doc,.docx,.pdf'
        ]);
        DB::table('settings')->insert([
            'key' => 'extensions_financial_form',
            'value' => '.xls,.xlsx,.doc,.docx,.pdf'
        ]);
        DB::table('settings')->insert([
            'key' => 'extensions_other_attachments',
            'value' => '.pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.zip,.rar,.tar'
        ]);
    }
}
