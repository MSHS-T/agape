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

        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_offer_id')->constrained('evaluation_offers')->cascadeOnDelete();
            $table->json('notation')->nullable();
            $table->json('grades')->nullable();
            $table->string('global_grade')->nullable();
            $table->json('comments')->nullable();
            $table->text('global_comment')->nullable();
            $table->text('devalidation_message')->nullable();
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
        Schema::dropIfExists('evaluations');
    }
};
