<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('applicant_id');
            $table->unsignedInteger('projectcall_id');

            // All form fields must be nullable because user must be able to save an incomplete application without submitting it
            // Section 1
            $table->unsignedInteger('carrier_id')->nullable();
            // Laboratories are linked using a pivot table in another migration
            $table->string('duration')->nullable();
            // Study fields are linked using a pivot table in another migration
            $table->date('target_date')->nullable();
            $table->text('theme')->nullable();
            $table->text('summary_fr')->nullable();
            $table->text('summary_en')->nullable();
            $table->text('keywords')->nullable();

            // Section 2
            // Partners are linked using a foreign key in application_partners table

            // Section 3
            $table->text('short_description')->nullable();

            // Section 4
            $table->float('amount_requested')->nullable();
            $table->float('other_fundings')->nullable();
            $table->float('total_expected_income')->nullable();
            $table->float('total_expected_outcome')->nullable();

            // Section 5
            // Files are linked using a foreign key in application_files table

            $table->timestamps();
            $table->timestamp('submitted_at')->nullable();

            $table->foreign('applicant_id')->references('id')->on('users');
            $table->foreign('projectcall_id')->references('id')->on('project_calls');
            $table->foreign('carrier_id')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
