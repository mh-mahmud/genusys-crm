<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $table = 'campaigns';
    protected $fillable = [
        'form_id','email_template_id','sms_template_id','campaign_title', 'start_date', 'end_date', 'description', 'campaign_type','template_type', 'campaign_limit', 'campaign_service', 'status', 'promotion_id','created_by'
    ];

    // public function promotion()
    // {
    //     return $this->belongsTo('App\Promotion');
    // }
   
}
