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
        Schema::create('leads_form', function (Blueprint $table) {
            $table->id();
            $table->char('form_id', 10)->nullable();
            $table->char('parent_id', 10)->nullable();
            $table->string('form_name');
            $table->text('form_description')->nullable();
            $table->tinyInteger('form_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads_form');
    }
};
