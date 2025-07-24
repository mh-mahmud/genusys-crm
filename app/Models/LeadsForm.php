<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LeadsForm extends Model
{
    use HasFactory;

    protected $table = 'leads_form';

    protected $fillable = [
        'form_id', 'parent_id', 'form_name', 'form_description', 'form_status'
    ];


    public function leadFormDetail()
    {
        return $this->hasMany(LeadFormDetail::class, 'form_id', 'form_id');
    }

}

