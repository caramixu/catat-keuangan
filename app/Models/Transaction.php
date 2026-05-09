<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'date',
        'description',
        'type',
        'proof'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
