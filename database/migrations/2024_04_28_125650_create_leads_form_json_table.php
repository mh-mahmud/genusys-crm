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
        Schema::create('leads_form_json', function (Blueprint $table) {
            $table->id();
            $table->char('form_id', 10);
            $table->string('form_name');
            $table->text('form_description')->nullable();
            $table->tinyInteger('form_status');
            $table->json('custom_form_fields');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads_form_json');
    }
};
