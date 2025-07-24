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
        Schema::create('invoice_custom_form', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_name');
            $table->text('field_details')->nullable();
            $table->text('footer_details')->nullable();
            $table->string('total_in_word')->nullable();
            $table->text('bank_details')->nullable();
            $table->text('issued_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_custom_form');
    }
};
