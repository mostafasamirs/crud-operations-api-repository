<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('url')->nullable();
            $table->string('mobile_link')->nullable();
            // recipients
            $table->boolean('app_users')->default(false);
            $table->boolean('website_users')->default(false);
            $table->boolean('admins')->default(false);

            // recipients
            $table->boolean('managers')->default(false);
            $table->boolean('members')->default(false);
            $table->boolean('both')->default(false);

            //notification type
            $table->boolean('system_notification')->default(false);
            $table->boolean('sms')->default(false);
            $table->boolean('email')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
