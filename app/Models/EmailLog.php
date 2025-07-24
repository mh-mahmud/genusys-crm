<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'email_log';

    protected $casts = [
        'email_to' => 'array',
        'email_cc' => 'array',
        'email_bcc' => 'array',
    ];


     public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
