<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $fillable = [
        'title',
        'price',
        'type'
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withPivot(['quantity', 'is_necessary']);
    }

    public function menu()
    {
        return $this->belongsToMany(Menu::class);
    }
}
