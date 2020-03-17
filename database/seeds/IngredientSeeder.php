<?php

use App\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredients = ['butter', 'meat', 'bread'];
        foreach ($ingredients as $ingredient)
        {
            Ingredient::create([
                'title' => $ingredient,
                'units' => 'gram',
                'price' => 150
            ]);
        }
    }
}
