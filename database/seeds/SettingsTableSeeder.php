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
            'key' => 'max_number_of_experts',
            'value' => 4
        ]);
        DB::table('settings')->insert([
            'key' => 'max_number_of_documents',
            'value' => 10
        ]);
        DB::table('settings')->insert([
            'key' => 'application_confirmation_email',
            'value' => 'Bonjour,<br/><br/>Votre dossier de candidature a &eacute;t&eacute; enregistr&eacute; sous le num&eacute;ro [ID].<br/>Vous pouvez y acc&eacute;der en ligne via ce lien : <a href=[LINK]>[LINK]</a>.<br/><br/>A bient&ocirc;t sur notre site,<br/><br/>L\'&eacute;quipe AAP MSH'
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_grid',
            'value' => json_encode([
                0 => [
                    "grade" => "C",
                    "details" => "Projet &agrave; conforter"
                ],
                1 => [
                    "grade" => "B",
                    "details" => "Bon projet"
                ],
                2 => [
                    "grade" => "A",
                    "details" => "Tr&egrave;s bon projet"
                ],
                3 => [
                    "grade" => "A+",
                    "details" => "Excellent projet"
                ],
            ])
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_1_title',
            'value' => 'Qualit&eacute; et ambition scientifique du projet'
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_2_title',
            'value' => 'Organisation du projet et moyens mis en oeuvre'
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_3_title',
            'value' => 'Impact et retomb&eacute;es du projet'
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_1_description',
            'value' => '<ul><li>Clart&eacute; des objectifs et des hypoth&egrave;ses de recherche</li><li>Caract&egrave;re interdisciplinaire du projet et effet structurant</li><li>Caract&egrave;re novateur, originalit&eacute;, progr&egrave;s par rapport &agrave; l\'&eacute;tat de l\'art</li><li>Faisabilit&eacute; notamment au regard des m&eacute;thodes, gestion des risques scientifiques</li></ul>'
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_2_description',
            'value' => '<ul><li>Comp&eacute;tence, expertise et implication du coordinateur scientique et des partenaires</li><li>Qualit&eacute; et compl&eacute;mentarit&eacute; de l\'&eacute;quipe, qualit&eacute; de la collaboration</li><li>Ad&eacute;quation aux objectifs des moyens mis en oeuvre et demand&eacute;s (coh&eacute;rence du projet)</li></ul>'
        ]);
        DB::table('settings')->insert([
            'key' => 'notation_3_description',
            'value' => '<ul><li>Impact scientifique, social, &eacute;conomique ou culturel</li><li>Capacit&eacute; du projet &agrave; r&eacute;pondre aux enjeux de recherche, acquisitions de nouvelles connaissances et de savoir-faire</li><li>Strat&eacute;gie de diffusion et de valorisation des r&eacute;sultats</li></ul>'
        ]);

    }
}
