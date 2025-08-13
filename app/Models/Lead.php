<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Lead extends Model
{
    use HasFactory;
       
   protected $table = 'leads';
   protected $fillable = [
       'form_id',
       'first_name',
       'middlename',
       'last_name',
       'email',
       'phone',
       'alternative_number',
       'contact_person_name',
       'gender',
       'dob',
       'marital_status',
       'address',
       'age',
       'company',
       'lead_status',
       'title',
       'lead_rating',
       'website',
       'lead_owner',
       'industry',
       'no_of_employee',
       'lead_source',
       'street',
       'city',
       'zip',
       'state',
       'country',
       'lead_start_date',
       'lead_notes',
       'created_by',
       'profile_image',
       'home_phone',
       'work_phone',
       'time_at_residence',
       'prior_address'
   ];

    public function leadsForm()
    {
        return $this->belongsTo(LeadsForm::class, 'form_id', 'form_id');
    }

    public function customer_data(): HasOne
    {
        return $this->hasOne(Customer::class);
    }
}
