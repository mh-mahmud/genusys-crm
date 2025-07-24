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
        Schema::create('email_log', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('campaign_id')->unsigned()->nullable();
            $table->bigInteger('lead_id')->unsigned()->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->char('email_from', 20);
            $table->char('email_to', 20);
            $table->string('email_subject');
            $table->text('email_content');
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
        Schema::dropIfExists('email_log');
    }
};
