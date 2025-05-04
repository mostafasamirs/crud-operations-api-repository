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
        Schema::create('f_a_q_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->string('question');
            $table->text('answer');
            $table->foreignId('f_a_q_id')->constrained('f_a_q_s')->onDelete('cascade');
            $table->unique(['locale','f_a_q_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f_a_q_translations');
    }
};
