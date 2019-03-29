<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilesToProjectCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_calls', function (Blueprint $table) {
            $table->string('application_form_filepath')->nullable();
            $table->string('financial_form_filepath')->nullable();
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
            $table->dropColumn('application_form_filepath');
            $table->dropColumn('financial_form_filepath');
        });
    }
}
