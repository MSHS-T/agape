<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveContactNameToApplicationLaboratories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_laboratory', function (Blueprint $table) {
            $table->string('contact_name')->nullable();
        });
        Schema::table('laboratories', function (Blueprint $table) {
            $table->dropColumn('contact_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laboratories', function (Blueprint $table) {
            $table->string('contact_name')->nullable();
        });
        Schema::table('application_laboratory', function (Blueprint $table) {
            $table->dropColumn('contact_name');
        });
    }
}
