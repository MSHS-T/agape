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
            $table->string('title')->nullable();
            $table->string('acronym')->nullable();
            $table->json('carrier')->nullable();
            $table->text('short_description')->nullable();
            $table->json('summary')->nullable();
            $table->json('keywords')->nullable();
            $table->text('other_laboratories')->nullable();
            $table->float('amount_requested')->nullable();
            $table->float('other_fundings')->nullable();
            $table->float('total_expected_income')->nullable();
            $table->float('total_expected_outcome')->nullable();
            $table->text('selection_comity_opinion')->nullable();
            $table->text('devalidation_message')->nullable();
            $table->schemalessAttributes('extra_attributes');
            $table->foreignId('creator_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('submitted_at')->nullable();
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
