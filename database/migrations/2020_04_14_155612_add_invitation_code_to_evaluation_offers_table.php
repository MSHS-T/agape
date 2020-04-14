<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvitationCodeToEvaluationOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_offers', function (Blueprint $table) {
            $table->unsignedInteger('expert_id')->nullable(true)->change();
            $table->string('invitation_code')->nullable(true);

            $table->foreign('invitation_code')->references('invitation')->on('invitations');
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
            $table->unsignedInteger('expert_id')->nullable(false)->change();
            $table->dropColumn('invitation_code');
        });
    }
}
