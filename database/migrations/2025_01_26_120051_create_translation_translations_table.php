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
        Schema::create('translation_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->text('value');
            $table->foreignId('translation_id')->constrained('translations')->onDelete('cascade');
            $table->unique(['locale', 'translation_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translation_translations');
    }
};
