<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $table = 'meetings';
    protected $fillable = [
        'lead_id',
        'recipients',
        'created_by',
        'meeting_subject',
        'meeting_description',
        'meeting_date',
        'meeting_link',
        'attachments',
        'duration',
        'send_email',
        'send_sms',
        'status',
        'meeting_feedback',
        'rating',
    ];


    public function user() {
        return $this->belongsTo(User::class, 'created_by');
    }

   
}
