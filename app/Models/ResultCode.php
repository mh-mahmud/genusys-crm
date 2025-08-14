<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultCode extends Model
{
    protected $table = 'result_codes';

    public function groupCode()
    {
        return $this->belongsTo(GroupCode::class, 'result_group_id');
    }

    /**
     * Relationship to ResultAction
     */
    public function resultAction()
    {
        return $this->belongsTo(ResultAction::class, 'result_action_id');
    }

    /**
     * Relationship to LeadStatus
     */
    public function leadStatus()
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id');
    }
}
