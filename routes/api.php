<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('ingredients', 'IngredientController');
    Route::apiResource('dishes', 'DishController');
    Route::apiResource('menu', 'MenuController');
});
