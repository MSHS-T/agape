<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Enums\CallType;

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
            $table->unsignedTinyInteger('type')->default(CallType::Unknown);
            $table->string('name');
            $table->unsignedSmallInteger('year');
            $table->text('description');
            $table->date('application_start_date');
            $table->date('application_end_date');
            $table->date('evaluation_start_date');
            $table->date('evaluation_end_date');
            $table->unsignedTinyInteger('number_of_experts');
            $table->unsignedTinyInteger('number_of_documents');
            $table->text('privacy_clause');
            $table->text('invite_email_fr');
            $table->text('invite_email_en');
            $table->text('help_experts');
            $table->text('help_candidates');
            $table->boolean('closed')->default(false);
            $table->unsignedInteger('creator_id');
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users');
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
