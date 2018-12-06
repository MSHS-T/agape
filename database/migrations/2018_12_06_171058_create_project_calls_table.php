<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_calls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->date('application_start_date');
            $table->date('application_end_date');
            $table->date('evaluation_start_date');
            $table->date('evaluation_end_date');
            $table->boolean('closed')->default(false);
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('project_id');
            $tables->morphs('call');
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_calls');
    }
}
