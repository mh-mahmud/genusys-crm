<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeadStatus;
use App\Models\ResultCode;

class ResultAction extends Model
{
    protected $table = 'result_action';

     protected $fillable = [
        'rule_code',
        'rule_description',
        'rule_based',
        'num_attempts',
        'callback',
        'dead',
        'lead_status_id',
        'next_dist',
        'result_code',
        'status',
        'created_by',
        'updated_by'
    ];

      public function leadStatus()
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id', 'id');
    }

    public function resultCode()
    {
        return $this->belongsTo(ResultCode::class, 'result_code', 'id');
    }
}
