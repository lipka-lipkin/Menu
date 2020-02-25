<?php

namespace App\Http\Controllers\Api;

use App\Dish;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dish\StoreDishRequest;
use App\Http\Requests\Api\Dish\UpdateDishRequest;
use App\Http\Resources\Api\DishResource;
use App\Ingredient;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $dishes = Dish::query()->latest()->paginate();
        return DishResource::collection($dishes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDishRequest $request
     * @return DishResource
     */
    public function store(StoreDishRequest $request)
    {
        $dish = Dish::create([
            'title' => $request->title,
            'price' => $request->price,
        ]);
        $ingredient = Ingredient::find($request->ingredients);
        $dish->ingredients()->attach($ingredient, [
            'quantity' => $request->quantity,
            'is_necessary' => $request->is_necessary
        ]);
        return DishResource::make($dish->load('ingredients'));
    }

    /**
     * Display the specified resource.
     *
     * @param Dish $dish
     * @return DishResource
     */
    public function show(Dish $dish)
    {
        return DishResource::make($dish);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDishRequest $request
     * @param Dish $dish
     * @return DishResource
     */
    public function update(UpdateDishRequest $request, Dish $dish)
    {
        $dish->update([
            'title' => $request->title,
            'price' => $request->price,
        ]);
        $ingredients = Ingredient::find($request->ingredients);
        $dish->ingredients()->detach();//sync
        $dish->ingredients()->attach($ingredients, [
            'quantity' => $request->quantity,
            'is_necessary' => $request->is_necessary
        ]);
        return DishResource::make($dish->load('ingredients'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Dish $dish
     * @return array
     * @throws Exception
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();
        return ['status' => 'ok'];
    }
}
