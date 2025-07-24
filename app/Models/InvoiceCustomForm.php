<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceCustomForm extends Model
{
    use HasFactory;

    protected $table = 'invoice_custom_form';

    protected $fillable = [
        'invoice_name',
        'field_details',
        'footer_details',
        'total_in_word',
        'bank_details',
        'issued_by',
    ];

    protected $casts = [
        'field_details' => 'array',
        'footer_details' => 'array',
    ];
}