<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    use HasFactory;

    protected $table = 'product_feature'; 

    protected $fillable = [
        'product_id',
        'p_feature_name',
        'unit_price',
        'description',
        'created_at',
        'updated_at',
    ];

    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
