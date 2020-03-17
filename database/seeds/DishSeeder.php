<?php

use App\Dish;
use App\Ingredient;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredients = Ingredient::all();
        $types = Dish::$type;
        foreach ($types as $type)
        {
            $dish = Dish::create([
                'title' => 'sandwich',
                'price' => 150,
                'type' => $type
            ]);
            $sync = [];
            foreach ($ingredients as $ingredient)
            {
                $sync[$ingredient->id] = [
                    'quantity' => 10,
                    'is_necessary' => true
                ];
            }
            $dish->ingredients()->sync($sync);
        }
    }
}
