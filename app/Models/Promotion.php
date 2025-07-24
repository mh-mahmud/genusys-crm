<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
	protected $fillable = [
        'promotion_title', 'description', 'file_location', 'start_date', 'end_date', 'promo_type', 'status'
    ];
    protected $table = 'promotions';
}
