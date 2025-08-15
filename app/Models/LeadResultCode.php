<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadResultCode extends Model
{
    use HasFactory;

    protected $table = 'lead_result_code';
    protected $fillable = ['lead_id', 'result_codes_id', 'lead_note', 'created_by'];

    public function lead_res_code()
    {
        return $this->belongsTo(ResultCode::class, 'result_codes_id');
    }
}
