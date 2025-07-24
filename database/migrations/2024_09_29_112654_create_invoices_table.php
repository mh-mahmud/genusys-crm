<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); // Foreign key to customers table
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('currency', 3)->default('BDT');
            $table->decimal('sub_total', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->enum('discount_type', ['No discount', 'Before tax', 'After tax'])->default('No discount');
            $table->decimal('adjustment', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->text('address')->nullable();
            $table->text('admin_note')->nullable();
            $table->text('client_note')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->text('item_description')->nullable();
            $table->tinyInteger('prevent_reminders')->nullable();
            $table->tinyInteger('is_recurring')->nullable();
            $table->string('payment_mode')->nullable();
            $table->unsignedBigInteger('sale_agent_id')->nullable(); // Foreign key to users or agents
            $table->timestamps(); // created_at and updated_at columns
            $table->softDeletes(); // deleted_at column for soft deletes
            
            // Foreign key constraints
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('sale_agent_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
