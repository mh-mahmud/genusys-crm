<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadFormDetail extends Model
{
    use HasFactory;
    protected $table = 'lead_form_details';

    protected $fillable = [
        'form_id',
        'field_name',
        'field_value',
        'table_name',
        'view_type',
        'form_size',
        'character_length',
        'is_index',
        'is_null',
        'is_unique',
    ];

    public function leadsForm()
    {
        return $this->belongsTo(LeadsForm::class, 'form_id', 'form_id');
    }
}
