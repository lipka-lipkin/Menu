<?php

use App\Dish;
use App\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dishes = Dish::all();
        $menus = ['snacks', 'hot meals', 'drinks', 'salad', 'dessert', 'soups', 'pizza'];
        foreach ($menus as $menu)
        {
            $menu = Menu::create([
                'title' => $menu
            ]);
            $menu->dishes()->sync($dishes->pluck('id'));
        }
    }
}
