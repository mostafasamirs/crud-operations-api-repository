<?php

use App\Helpers\Database\MigrationHelper;
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
        Schema::create('slider_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('short_description')->nullable();
            MigrationHelper::seoColumns($table);
            $table->foreignId('slider_id')->constrained('sliders')->onDelete('cascade');
            $table->unique(['locale', 'slider_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_translations');
    }
};
