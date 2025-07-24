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
        Schema::create('lead_form_details', function (Blueprint $table) {
            $table->id();
            $table->char('form_id', 10)->nullable(false);
            $table->string('field_name', 191)->nullable();
            $table->string('field_value', 191)->nullable();
            $table->string('table_name', 191)->nullable(false);
            $table->integer('character_length')->nullable();
            $table->tinyInteger('is_index')->nullable();
            $table->tinyInteger('is_null')->nullable();
            $table->tinyInteger('is_unique')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_form_details');
    }
};
