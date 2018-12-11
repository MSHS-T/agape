<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_partners', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_id');
            $table->boolean('major');
            // Common fields
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('discipline'); // Also used for "origin" for a minor partner
            $table->string('status'); // Also used for "function" for a minor partner
            $table->string('team'); // Also used for "role" for a minor partner

            // Fields for major partner
            $table->unsignedInteger('laboratory_id')->nullable();
            // Fields for minor partner
            $table->string('laboratory')->nullable();

            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('applications');
            $table->foreign('laboratory_id')->references('id')->on('laboratories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_partners');
    }
}
