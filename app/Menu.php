<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'title',
    ];

    public static $type = [
        'breakfast',
        'lunch',
        'dinner',
        'afternoon snack',
        'supper'
    ];

    public function dishes()
    {
        return $this->belongsToMany(Dish::class);
    }
}
