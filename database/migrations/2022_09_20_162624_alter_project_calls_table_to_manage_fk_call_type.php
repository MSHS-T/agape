<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProjectCallsTableToManageFkCallType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_calls', function (Blueprint $table) {
            $table->renameColumn('type', 'project_call_type_id');
        });
        Schema::table('project_calls', function (Blueprint $table) {
            $table->unsignedBigInteger('project_call_type_id')->nullable(false)->change();
            $table->foreign('project_call_type_id')->references('id')->on('project_call_types');
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
            //
        });
    }
}
