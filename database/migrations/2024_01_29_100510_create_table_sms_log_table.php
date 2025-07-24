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
        Schema::create('sms_log', function (Blueprint $table) {
            $table->id();
            $table->char('campaign_id', 20)->nullable();
            $table->char('user_id', 20);
            $table->char('sms_from', 20);
            $table->char('sms_to', 20);
            $table->string('sms_text');
            $table->dateTime('log_time')->nullable();
            $table->dateTime('delivery_time')->nullable();
            $table->tinyInteger('send_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_sms_log');
    }
};
