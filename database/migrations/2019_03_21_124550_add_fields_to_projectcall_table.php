<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToProjectcallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_calls', function (Blueprint $table) {
            $table->unsignedTinyInteger('number_of_keywords');
            $table->unsignedTinyInteger('number_of_laboratories');
            $table->unsignedTinyInteger('number_of_study_fields');
            $table->unsignedTinyInteger('number_of_target_dates')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_calls', function (Blueprint $table) {
            $table->dropColumn('number_of_keywords');
            $table->dropColumn('number_of_laboratories');
            $table->dropColumn('number_of_study_fields');
            $table->dropColumn('number_of_target_dates');
        });
    }
}
