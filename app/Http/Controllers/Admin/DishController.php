<?php

namespace App\Http\Controllers\Admin;

use App\Dish;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Dish\IndexDishRequest;
use App\Http\Requests\Admin\Dish\StoreDishRequest;
use App\Http\Requests\Admin\Dish\UpdateDishRequest;
use App\Http\Resources\Admin\DishResource;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexDishRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexDishRequest $request)
    {
        $search = $request->search;
        $dishes = Dish::latest()
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
            'type' => $request->type
        ]);
        $attach = [];
        foreach ($request->ingredients as $ingredient)
        {
            $attach[$ingredient['id']] = [
                'quantity' => $ingredient['quantity'],
                'is_necessary' => $ingredient['is_necessary']
            ];
        }
        $dish->ingredients()->attach($attach);
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
        return DishResource::make($dish->load('ingredients'));
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
            'type' => $request->type
        ]);
        $sync = [];
        foreach ($request->ingredients as $ingredient)
        {
            $sync[$ingredient['id']] = [
                'quantity' => $ingredient['quantity'],
                'is_necessary' => $ingredient['is_necessary'],
            ];
        }
        $dish->ingredients()->sync($sync);
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
