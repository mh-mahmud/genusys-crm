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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('user_id', 20)->nullable();
            $table->string('username', 191)->unique(); // Added username column
            $table->string('first_name', 191);
            $table->string('last_name', 191);
            $table->string('phone_number', 20)->nullable();
            $table->string('email')->unique();
            $table->char('user_type', 16)->nullable();
            $table->char('gender', 1)->nullable();
            $table->string('profile_image', 191)->nullable();
            $table->text('address')->nullable();
            $table->char('role_id', 16)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
