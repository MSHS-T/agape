<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_id');
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('expert_id');
            $table->boolean('accepted')->nullable();
            $table->string('justification')->nullable();
            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('applications');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('expert_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_offers');
    }
}
