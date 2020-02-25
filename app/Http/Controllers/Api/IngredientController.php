<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Ingredient\StoreIngredientRequest;
use App\Http\Requests\Api\Ingredient\UpdateIngredientRequest;
use App\Http\Resources\Api\IngredientResource;
use App\Ingredient;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $ingredients = Ingredient::query()->latest()->paginate();
        return IngredientResource::collection($ingredients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreIngredientRequest $request
     * @return IngredientResource
     */
    public function store(StoreIngredientRequest $request)
    {
        $ingredient = Ingredient::create([
            'title' => $request->title,
            'quantity' => $request->quantity,//
            'units' => $request->units,
            'price' => $request->price
        ]);
        return IngredientResource::make($ingredient);
    }

    /**
     * Display the specified resource.
     *
     * @param Ingredient $ingredient
     * @return IngredientResource
     */
    public function show(Ingredient $ingredient)
    {
        return IngredientResource::make($ingredient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateIngredientRequest $request
     * @param Ingredient $ingredient
     * @return IngredientResource
     */
    public function update(UpdateIngredientRequest $request, Ingredient $ingredient)
    {
        $ingredient->update([
            'title' => $request->title,
            'quantity' => $request->quantity,
            'units' => $request->units,
            'price' => $request->price
        ]);
        return IngredientResource::make($ingredient);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ingredient $ingredient
     * @return array
     * @throws Exception
     */
    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return ['status' => 'ok'];
    }
}
