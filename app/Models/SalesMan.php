<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesMan extends Model
{
    use HasFactory;
    protected $fillable = [
    	'name',
    	'email',
    	'phone_number',
    	'description',
    	'address',
    	'profile_image',
    	'status',
    ];
    protected $table = 'salesman';
}
