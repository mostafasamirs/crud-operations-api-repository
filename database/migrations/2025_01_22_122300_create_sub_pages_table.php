<?php

use App\Enums\PagePositionEnum;
use App\Enums\StatusType;
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
        Schema::create('sub_pages', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->boolean('is_active')->default(StatusType::getNotActive());
            $table->string('position')->default(PagePositionEnum::HEADER);
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_pages');
    }
};
