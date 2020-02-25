<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $fillable = [
        'title',
        'price'
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }

    public function menu()
    {
        return $this->belongsToMany(Menu::class);
    }
}
