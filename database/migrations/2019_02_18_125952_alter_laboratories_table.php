<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLaboratoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laboratories', function (Blueprint $table) {
            $table->string('name')->nullable(true)->change();
            $table->string('unit_code')->nullable(true)->change();
            $table->string('director_email')->nullable(true)->change();
            $table->string('regency')->nullable(true)->change();
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
            $table->string('name')->nullable(false)->change();
            $table->string('unit_code')->nullable(false)->change();
            $table->string('director_email')->nullable(false)->change();
            $table->string('regency')->nullable(false)->change();
        });
    }
}
