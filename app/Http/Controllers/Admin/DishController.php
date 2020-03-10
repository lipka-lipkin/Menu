<?php

namespace App\Http\Controllers\Admin;

use App\Dish;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Dish\IndexDishRequest;
use App\Http\Requests\Admin\Dish\StoreDishRequest;
use App\Http\Requests\Admin\Dish\UpdateDishRequest;
use App\Http\Resources\Admin\DishResource;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DishController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Dish::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexDishRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexDishRequest $request)
    {
        $cacheKey = 'dish.' .$request->page .'.'. $request->search .'.'.$request->from. '.'.$request->to;
        return Cache::tags('dish')->remember($cacheKey, 5000, function () use ($request){
            $dishes =  Dish::latest()
                ->when($request->search, function ($query, $search){
                    $query->where('title', 'like', '%'.$search.'%');
                })
                ->when($request->from, function ($query, $from){
                    $query->where('created_at', '>=', $from);
                })
                ->when($request->to, function ($query, $to){
                    $query->where('created_at', '<=', $to);
                })
                ->paginate()->appends(['search' => $request->search])
            ;
            return DishResource::collection($dishes);
        });
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
        Cache::tags('dish')->flush();
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
        $cache = 'dish.'.$dish->id;
        return Cache::tags('dish')->remember($cache, 5000, function () use ($dish){
            return DishResource::make($dish->load('ingredients'));
        });
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
        Cache::tags('dish')->flush();
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
        Cache::tags('dish')->flush();
        return ['status' => 'ok'];
    }
}
