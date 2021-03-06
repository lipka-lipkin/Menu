<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::post('auth/login', 'AuthController@login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('ingredients', 'IngredientController');
    Route::apiResource('dishes', 'DishController');
    Route::apiResource('menu', 'MenuController');
    Route::post('get-csv', 'CsvController@store');
});
