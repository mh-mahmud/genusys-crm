<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloggerCategory extends Model
{
    use HasFactory;
    protected $table = 'bloggers_category';
    protected $fillable = [
        'parent_id',
        'category_name',
        'category_description',
        'category_image',
        'status'
    ];

    public function product()
    {
        return $this->hasOne(Product::class);
    }

    // public function blog() {
    //     return $this->hasOne(Blog::class);
    // }
}
