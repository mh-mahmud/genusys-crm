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
        // main fields
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
        'updated_by',

        // new fields for distribution & park logic
        'distribution_priority',
        'after_1st_park_priority',
        'after_2nd_park_priority',
        'distribution_time',
        'after_1st_park_time',
        'after_2nd_park_time',

        //new fields for general rules
        'attempts_general',
        'after_1st_park_priority_general',
        'after_2nd_park_priority_general',
        'apply_condition',
        'park_cycle_before_dead',
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
