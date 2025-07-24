<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lead;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lead_data(): HasOne
    {
        return $this->hasOne(Lead::class, 'id', 'lead_id');
    }
}
