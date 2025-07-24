<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_category_id',
        'blog_name',
        'blog_description',
        'blog_image',
        'status'
    ];

    public function blog_category()
    {
        return $this->belongsTo(BloggerCategory::class, 'blog_category_id');
    }
}
