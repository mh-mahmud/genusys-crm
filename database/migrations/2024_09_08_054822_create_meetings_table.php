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
        Schema::create('meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('lead_id')->nullable();
            $table->string('recipients', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->string('meeting_subject', 191)->collation('utf8mb4_unicode_ci');
            $table->text('meeting_description')->collation('utf8mb4_unicode_ci');
            $table->dateTime('meeting_date');
            $table->string('meeting_link', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('attachments', 191)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('duration', 100)->collation('utf8mb4_unicode_ci')->nullable();
            $table->tinyInteger('send_email')->nullable();
            $table->tinyInteger('send_sms')->nullable();
            $table->text('meeting_feedback')->collation('utf8mb4_unicode_ci')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
