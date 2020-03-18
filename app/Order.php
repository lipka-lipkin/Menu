<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }

    public function orderIngredients()
    {
        return $this->belongsToMany(Ingredient::class, 'dish_ingredient_order');
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class)->withPivot('amount');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
}
