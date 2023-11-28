<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with=[
        'category',
        'expirationDates'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function expirationDates(): HasMany
    {
        return $this->hasMany(Expirationdate::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

}
