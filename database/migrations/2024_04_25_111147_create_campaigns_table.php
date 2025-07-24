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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->char('form_id', 10)->nullable();
            $table->string('email_template_id', 20)->nullable();
            $table->string('sms_template_id', 20)->nullable(); 
            $table->string('campaign_title');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->text('description')->nullable();
            $table->string('campaign_type')->nullable();
            $table->string('template_type')->nullable();
            $table->integer('campaign_limit')->nullable();
            $table->string('campaign_service')->nullable();
            $table->tinyInteger('status');
            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::table('campaigns', function (Blueprint $table) {
            $table->index('promotion_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
