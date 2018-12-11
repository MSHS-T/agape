<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('offer_id');
            $table->unsignedTinyInteger('grade1');
            $table->string('comment1');
            $table->unsignedTinyInteger('grade2');
            $table->string('comment2');
            $table->unsignedTinyInteger('grade3');
            $table->string('comment3');
            $table->unsignedTinyInteger('global_grade');
            $table->string('global_comment');
            $table->timestamps();
            $table->timestamp('submitted_at')->nullable();

            $table->foreign('offer_id')->references('id')->on('evaluation_offers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
