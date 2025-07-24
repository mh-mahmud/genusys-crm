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
        Schema::create('campaign_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('campaign_id')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->unique();
            $table->Integer('email_template_id')->nullable();
            $table->Integer('sms_template_id')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_data');
    }
};
