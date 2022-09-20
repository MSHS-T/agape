<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRetryHistoryColumnToEvaluationOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_offers', function (Blueprint $table) {
            $table->string('retry_history')->nullable(false)->default('[]');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_offers', function (Blueprint $table) {
            $table->dropColumn('retry_history');
        });
    }
}
