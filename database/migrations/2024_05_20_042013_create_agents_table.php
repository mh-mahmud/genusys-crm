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
        Schema::create('agents', function (Blueprint $table) {
            $table->char('agent_id', 4)->nullable()->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('first_name', 191);
            $table->string('last_name', 191);
            $table->string('phone_number', 20)->nullable();
            $table->date('birth_day')->nullable();
            $table->tinyInteger('status');
            $table->char('role_id', 10)->nullable();
            $table->char('did', 10)->nullable();
            $table->char('seat_id', 3)->nullable();
            $table->char('skill_id', 2)->nullable();
            $table->string('gender', 191)->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->string('performance', 191)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
