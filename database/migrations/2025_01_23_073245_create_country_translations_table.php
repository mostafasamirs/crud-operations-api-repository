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
        Schema::create('country_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->string('name')->nullable();
            $table->string('default_currency')->nullable();
            $table->string('nationality')->nullable();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->unique(['locale', 'country_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_translations');
    }
};
