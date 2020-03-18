<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'index_ingredient',
                'display_name' => 'список_ингредиентов',
            ],
            [
                'name' => 'store_ingredient',
                'display_name' => 'создание_ингредиента',
            ],
            [
                'name' => 'show_ingredient',
                'display_name' => 'отображение_ингредиента',
            ],
            [
                'name' => 'update_ingredient',
                'display_name' => 'обновление_ингредиента',
            ],
            [
                'name' => 'delete_ingredient',
                'display_name' => 'удаление_ингредиента',
            ],
            [
                'name' => 'index_dish',
                'display_name' => 'список_блюд',
            ],
            [
                'name' => 'store_dish',
                'display_name' => 'создание_блюда',
            ],
            [
                'name' => 'show_dish',
                'display_name' => 'отображение_блюда',
            ],
            [
                'name' => 'update_dish',
                'display_name' => 'обновление_блюда',
            ],
            [
                'name' => 'delete_dish',
                'display_name' => 'удаление_блюда',
            ],
            [
                'name' => 'show_menu',
                'display_name' => 'список_ингредиента',
            ],
            [
                'name' => 'store_menu',
                'display_name' => 'создание_ингредиента',
            ],
            [
                'name' => 'show_menu',
                'display_name' => 'отображение_ингредиента',
            ],
            [
                'name' => 'update_menu',
                'display_name' => 'обновление_ингредиента',
            ],
            [
                'name' => 'delete_menu',
                'display_name' => 'удаление_ингредиента',
            ],
        ];

        foreach ($permissions as $permission)
        {
            Permission::updateOrCreate([
                'name' => $permission['name'],
            ],[
                'display_name' => $permission['display_name'],
            ]);
        }
    }
}
