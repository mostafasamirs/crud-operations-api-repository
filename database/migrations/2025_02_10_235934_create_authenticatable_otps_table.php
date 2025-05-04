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
        Schema::create('authenticatable_otps', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('code');
            $table->string('email');
            $table->boolean('active')->default(1);
            $table->nullableMorphs('authenticatable', 'authenticatable_otp_type_id_index');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authenticatable_otps');
    }
};
