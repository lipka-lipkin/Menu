<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ingredient\IndexIngredientRequest;
use App\Http\Requests\Admin\Ingredient\StoreIngredientRequest;
use App\Http\Requests\Admin\Ingredient\UpdateIngredientRequest;
use App\Http\Resources\Admin\IngredientResource;
use App\Ingredient;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IngredientController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Ingredient::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexIngredientRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexIngredientRequest $request)
    {
        $search = $request->search;
        $ingredients = Ingredient::latest()
            ->when($search, function ($query, $search){
                $query->where('title', 'like', '%'.$search.'%');
            })
            ->when($request->from, function ($query, $from){
                $query->where('created_at', '>=', $from);
            })
            ->when($request->to, function ($query, $to){
                $query->where('created_at', '<=', $to);
            })
            ->paginate()->appends(['search' => $search])
        ;
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
