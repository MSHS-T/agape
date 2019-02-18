<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->string('first_name')->nullable(true)->change();
            $table->string('last_name')->nullable(true)->change();
            $table->string('email')->nullable(true)->change();
            $table->string('phone')->nullable(true)->change();
            $table->string('status')->nullable(true)->change();
            $table->dropUnique(['email', 'is_workshop']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->string('first_name')->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
            $table->string('status')->nullable(false)->change();
            $table->unique(['email', 'is_workshop']);
        });
    }
}
