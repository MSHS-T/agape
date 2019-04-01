<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->text('comment1')->nullable(true)->change();
            $table->text('comment2')->nullable(true)->change();
            $table->text('comment3')->nullable(true)->change();
            $table->text('global_comment')->nullable(true)->change();
            $table->unsignedSmallInteger('grade1')->nullable(true)->change();
            $table->unsignedSmallInteger('grade2')->nullable(true)->change();
            $table->unsignedSmallInteger('grade3')->nullable(true)->change();
            $table->unsignedSmallInteger('global_grade')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->string('comment1')->nullable(false)->change();
            $table->string('comment2')->nullable(false)->change();
            $table->string('comment3')->nullable(false)->change();
            $table->string('global_comment')->nullable(false)->change();
            $table->unsignedSmallInteger('grade1')->nullable(false)->change();
            $table->unsignedSmallInteger('grade2')->nullable(false)->change();
            $table->unsignedSmallInteger('grade3')->nullable(false)->change();
            $table->unsignedSmallInteger('global_grade')->nullable(false)->change();
        });
    }
}
