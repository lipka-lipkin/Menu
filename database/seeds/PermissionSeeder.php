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
                'name' => 'index-ingredient',
                'display_name' => 'список-ингредиентов',
            ],
            [
                'name' => 'store-ingredient',
                'display_name' => 'создание-ингредиента',
            ],
            [
                'name' => 'show-ingredient',
                'display_name' => 'отображение-ингредиента',
            ],
            [
                'name' => 'update-ingredient',
                'display_name' => 'обновление-ингредиента',
            ],
            [
                'name' => 'delete-ingredient',
                'display_name' => 'удаление-ингредиента',
            ],
            [
                'name' => 'index-dish',
                'display_name' => 'список-блюд',
            ],
            [
                'name' => 'store-dish',
                'display_name' => 'создание-блюда',
            ],
            [
                'name' => 'show-dish',
                'display_name' => 'отображение-блюда',
            ],
            [
                'name' => 'update-dish',
                'display_name' => 'обновление-блюда',
            ],
            [
                'name' => 'delete-dish',
                'display_name' => 'удаление-блюда',
            ],
            [
                'name' => 'show-menu',
                'display_name' => 'список-ингредиента',
            ],
            [
                'name' => 'store-menu',
                'display_name' => 'создание-ингредиента',
            ],
            [
                'name' => 'show-menu',
                'display_name' => 'отображение-ингредиента',
            ],
            [
                'name' => 'update-menu',
                'display_name' => 'обновление-ингредиента',
            ],
            [
                'name' => 'delete-menu',
                'display_name' => 'удаление-ингредиента',
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
