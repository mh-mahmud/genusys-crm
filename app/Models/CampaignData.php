<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignData extends Model
{
    use HasFactory;

    protected $table = 'campaign_data';

    protected $fillable = [
        'campaign_id',
        'phone',
        'email',
        'email_template_id',
        'sms_template_id',
        'csv_id',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
