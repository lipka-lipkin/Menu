<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public static $chunk = 20;

    protected $fillable = [
        'title',
    ];

    public function dishes()
    {
        return $this->belongsToMany(Dish::class);
    }
}
