<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatorForeignKeyToStudyFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('study_fields', function (Blueprint $table) {
            $table->unsignedInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('study_fields', function (Blueprint $table) {
            $table->dropForeign('study_fields_creator_id_foreign');
            $table->dropColumn('creator_id');
        });
    }
}
