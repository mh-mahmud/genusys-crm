<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];
}
