<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Menu\StoreMenuRequest;
use App\Http\Requests\Api\Menu\UpdateMenuRequest;
use App\Http\Resources\Api\MenuResource;
use App\Menu;
use App\Dish;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $menu = Menu::query()->latest()->paginate();
        return MenuResource::collection($menu);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMenuRequest $request
     * @return MenuResource
     */
    public function store(StoreMenuRequest $request)
    {
        $menu = Menu::create([
            'title' => $request->title,
            'price' => $request->price
        ]);
        $dishes = Dish::find($request->dishes);//
        dd($dishes);
        $menu->dishes()->attach($dishes, [//
            'type' => $request->type//
        ]);//
        return MenuResource::make($menu->load('dishes'));
    }

    /**
     * Display the specified resource.
     *
     * @param Menu $menu
     * @return MenuResource
     */
    public function show(Menu $menu)
    {
        return MenuResource::make($menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMenuRequest $request
     * @param Menu $menu
     * @return MenuResource
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->update([
            'title' => $request->title,
            'price' => $request->price
        ]);
        $dishes = Dish::find($request->dishes);
        $menu->dishes()->detach();
        $menu->dishes()->attach($dishes, [
            'type' => $request->type
        ]);
//        [1,2]
//        [1 => ['type' => $request->type], 2 => ['type' => $request->type2]]
        return MenuResource::make($menu->load('dishes'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Menu $menu
     * @return array
     * @throws Exception
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return ['status' => 'ok'];
    }
}
