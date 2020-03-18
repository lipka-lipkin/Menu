<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'title',
        'units',
        'price'
    ];

    public static $units = [
        'liter',
        'kilogram',
        'gram'
    ];

    public function dishes()
    {
        return $this->belongsToMany(Dish::class)->withPivot(['quantity', 'is_necessary']);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
