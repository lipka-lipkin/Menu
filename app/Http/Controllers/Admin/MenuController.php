<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Menu\IndexMenuRequest;
use App\Http\Requests\Admin\Menu\StoreMenuRequest;
use App\Http\Requests\Admin\Menu\UpdateMenuRequest;
use App\Http\Resources\Admin\MenuResource;
use App\Menu;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexMenuRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexMenuRequest $request)
    {
        $search = $request->search;
        $menu = Menu::latest()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%'.$search.'%');
            })
            ->when($request->from, function ($query, $from){
                $query->where('created_at', '>=', $from);
            })
            ->when($request->to, function ($query, $to){
                $query->where('created_at', '<=', $to);
            })
            ->paginate()->appends(['search' => $search])
        ;
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
        ]);
        $attach = [];
        foreach ($request->dishes as $dish)
        {
            $attach[] = $dish['id'];
        }
        $menu->dishes()->attach($attach);
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
        return MenuResource::make($menu->load('dishes'));
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
        ]);
        $sync = [];
        foreach ($request->dishes as $dish)
        {
            $sync[] = $dish['id'];
        }
        $menu->dishes()->sync($sync);
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
