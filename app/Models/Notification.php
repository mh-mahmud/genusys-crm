<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    public $timestamps = false; 
    protected $fillable = [
        'lead_id',
        'user_id',
        'notify_msg',
        'notify_date',
        'notify_datetime',
        'notify_time',
        'notify_type',
        'send_email',
        'send_sms',
        'notify_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'notify_date' => 'date',
        'notify_datetime' => 'datetime',
        'notify_time' => 'datetime:H:i:s',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'notify_by');
    }
}
