<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $primaryKey = 'agent_id';
    public $incrementing = false;
    protected $keyType = 'string';
	protected $fillable = [
        'agent_id',
        'first_name',
        'last_name',
        'phone_number',
        'gender',
        'birth_day',
        'status',
        'role_id',
        'did',
        'seat_id',
        'skill_id',
        'user_id',
        'performance',
        'address',
        'description',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $table = 'agents';
}
