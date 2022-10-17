<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotationGuideOnProjectCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $title1 = \App\Setting::get("notation_1_title") ?? 'Qualité et ambition scientifique du projet';
        $title2 = \App\Setting::get("notation_2_title") ?? 'Organisation du projet et moyens mis en oeuvre';
        $title3 = \App\Setting::get("notation_3_title") ?? 'Impact et retombées du projet';
        $description1 = \App\Setting::get("notation_1_description") ?? '<ul><li>Clarté des objectifs et des hypothèses de recherche</li><li>Caractère interdisciplinaire du projet et effet structurant</li><li>Caractère novateur, originalité, progrès par rapport à l\'état de l\'art</li><li>Faisabilité notamment au regard des méthodes, gestion des risques scientifiques</li></ul>';
        $description2 = \App\Setting::get("notation_2_description") ?? '<ul><li>Compétence, expertise et implication du coordinateur scientfiique et des partenaires</li><li>Qualité et complémentarité de l\'équipe, qualité de la collaboration</li><li>Adéquation aux objectifs des moyens mis en oeuvre et demandés (cohérence du projet)</li></ul>';
        $description3 = \App\Setting::get("notation_3_description") ?? '<ul><li>Impact scientifique, social, économique ou culturel</li><li>Capacité du projet à répondre aux enjeux de recherche, acquisitions de nouvelles connaissances et de savoir-faire</li><li>Stratégie de diffusion et de valorisation des résultats</li></ul>';
        Schema::table('project_calls', function (Blueprint $table) use ($title1, $title2, $title3, $description1, $description2, $description3) {
            $table->string('notation_1_title')
                ->nullable(false)
                ->default(str_replace("'", "''", $title1));
            $table->string('notation_1_description', 5000)
                ->nullable(false)
                ->default(str_replace("'", "''", $description1));
            $table->string('notation_2_title')
                ->nullable(false)
                ->default(str_replace("'", "''", $title2));
            $table->string('notation_2_description', 5000)
                ->nullable(false)
                ->default(str_replace("'", "''", $description2));
            $table->string('notation_3_title')
                ->nullable(false)
                ->default(str_replace("'", "''", $title3));
            $table->string('notation_3_description', 5000)
                ->nullable(false)
                ->default(str_replace("'", "''", $description3));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
