<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // Table name if it's not following Laravel's naming convention
    protected $table = 'invoices';

    // The attributes that are mass assignable
    protected $fillable = [
        'customer_id',
        'invoice_number',
        'ref_no',
        'ps_id',
        'invoice_custom_form_id',
        'invoice_date',
        'due_date',
        'currency',
        'sub_total',
        'vat',
        'discount',
        'discount_type',
        'adjustment',
        'total_amount',
        'total_tax',
        'address',
        'admin_note',
        'client_note',
        'terms_conditions',
        'item_description',
        'payment_details',
        'prevent_reminders',
        'invoice_status',
        'is_recurring',
        'payment_mode',
        'sale_agent_id',
        'created_by',
        'invoice_status',
        'approval_status',
        'custom_footer_details'
    ];

    // Dates to handle date and soft delete functionality
    protected $dates = ['invoice_date', 'due_date', 'deleted_at'];

    protected $casts = [
        'payment_details' => 'array',
    ];

    /**
     * Get the customer that owns the invoice.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the sale agent associated with the invoice.
     */
    public function saleAgent()
    {
        return $this->belongsTo(Agent::class, 'sale_agent_id', 'agent_id');
    }

    
}