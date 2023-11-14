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

        Schema::create('project_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_call_type_id')->nullable()->constrained('project_call_types');
            $table->string('reference')->unique();
            $table->string('year');
            $table->json('title');
            $table->json('description');
            $table->date('application_start_date');
            $table->date('application_end_date');
            $table->date('evaluation_start_date');
            $table->date('evaluation_end_date');
            $table->json('privacy_clause');
            $table->json('invite_email');
            $table->json('help_experts');
            $table->json('help_candidates');
            $table->json('notation');
            $table->schemalessAttributes('extra_attributes');
            $table->foreignId('creator_id')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_calls');
    }
};
