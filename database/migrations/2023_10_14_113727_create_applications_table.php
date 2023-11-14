<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_call_id')->constrained('project_calls')->cascadeOnDelete();
            $table->string('reference')->unique();
            $table->string('title');
            $table->string('acronym');
            $table->text('theme');
            $table->text('short_description');
            $table->json('summary');
            $table->json('keywords');
            $table->text('other_laboratories');
            $table->float('amount_requested');
            $table->float('other_fundings');
            $table->float('total_expected_income');
            $table->float('total_expected_outcome');
            $table->text('selection_comity_opinion');
            $table->string('devalidation_message');
            $table->schemalessAttributes('extra_attributes');
            $table->foreignId('applicant_id')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->dateTime('submitted_at');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
