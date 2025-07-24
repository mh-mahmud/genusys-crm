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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->char('form_id', 10)->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable()->unique();
            $table->string('phone');
            $table->string('alternative_number')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('address')->nullable();
            $table->integer('age')->nullable();
            $table->string('company')->nullable();
            $table->tinyInteger('lead_status');
            $table->string('title')->nullable();
            $table->integer('lead_rating')->nullable();
            $table->string('website')->nullable();
            $table->string('lead_owner')->nullable();
            $table->string('industry')->nullable();
            $table->integer('no_of_employee')->nullable();
            $table->string('lead_source')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->text('lead_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
