<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // protected $fillable = [
    // 	'name',
    // 	'product_type',
    // 	'product_cost',
    // 	'product_value',
    // 	'status',
    // 	'description',
    // 	'product_code'
    // ];

    protected $guarded = ['id'];


	public function features()
    {
        return $this->hasMany(ProductFeature::class, 'product_id', 'id');
    }

}
