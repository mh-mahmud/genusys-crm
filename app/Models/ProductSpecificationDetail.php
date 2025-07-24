<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecificationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id',
        'product_id',
        'product_feature_id',
        'product_feature_name',
        'unit_price',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}