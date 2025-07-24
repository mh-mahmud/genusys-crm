<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsQueue extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'sms_queue';
}
