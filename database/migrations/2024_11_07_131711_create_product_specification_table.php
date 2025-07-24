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
        Schema::create('product_specification', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedInteger('product_id')->nullable();
            $table->string('work_order_number', 50); 
            $table->decimal('work_order_value', 15, 2); 
            $table->string('work_order_file', 255)->nullable(); 
            $table->string('work_order_rate', 255)->nullable(); 
            $table->decimal('purchase_order_value', 15, 2)->nullable();
            $table->string('purchase_order_file', 255)->nullable(); 
            $table->date('amc_start_date')->nullable(); 
            $table->date('amc_renewal_date')->nullable(); 
            $table->string('amc_rate', 255)->nullable(); 
            $table->decimal('amc_effective_amount', 15, 2)->nullable(); 
            $table->string('amc_agreement_documents', 255)->nullable();
            $table->string('service_type', 50)->nullable();
            $table->text('software_value')->nullable(); 
            $table->text('hardware_value')->nullable(); 
            $table->text('implementation_value')->nullable();
            $table->string('invoice_mushak_file', 255)->nullable(); 
            $table->string('tax_exemption_certificate', 255)->nullable(); 
            $table->text('note')->nullable();
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_specification');
    }
};
