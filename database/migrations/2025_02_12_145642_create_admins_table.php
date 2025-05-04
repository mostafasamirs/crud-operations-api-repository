<?php

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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('mobile')->unique();
            $table->string('identity')->unique();
            $table->boolean('is_active')->default(StatusType::getNotActive());
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->foreignId('nationality_id')->constrained('countries')->onDelete('cascade');
            $table->text('address')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
