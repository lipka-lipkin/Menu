<?php

namespace App\Providers;

use App\Dish;
use App\Ingredient;
use App\Menu;
use App\Policies\Admin\DishPolicy;
use App\Policies\Admin\IngredientPolicy;
use App\Policies\Admin\MenuPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Ingredient::class => IngredientPolicy::class,
        Dish::class => DishPolicy::class,
        Menu::class => MenuPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
