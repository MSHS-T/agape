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
            $table->unsignedTinyInteger('grade1');
            $table->unsignedTinyInteger('grade2');
            $table->unsignedTinyInteger('grade3');
            $table->unsignedTinyInteger('global_grade');
            $table->text('comment1');
            $table->text('comment2');
            $table->text('comment3');
            $table->text('global_comment');
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
