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

        Schema::create('evaluation_offers', function (Blueprint $table) {
            $table->id();
            $table->boolean('accepted')->nullable();
            $table->text('justification');
            $table->schemalessAttributes('extra_attributes');
            $table->foreignId('creator_id')->nullable()->constrained('users');
            $table->foreignId('expert_id')->nullable()->constrained('users');
            $table->foreignId('invitation_id')->nullable()->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_offers');
    }
};
