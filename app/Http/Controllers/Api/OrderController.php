<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\OrderStoreRequest;
use App\Http\Requests\Api\Order\UpdateOrderRequest;
use App\Http\Resources\Api\OrderResource;
use App\Menu;
use App\Order;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderStoreRequest $request
     * @return OrderResource
     */
    public function store(OrderStoreRequest $request)
    {
        $attachIngredient = [];
        $attachDish = [];
        $price = 0;

        $menu = Menu::findOrFail(collect($request->dishes)->pluck('menu_id'))
            ->keyBy('id');

        foreach ($request->dishes as $dish) {

            $dishObj = $menu->get($dish['menu_id'])
                ->dishes()
                ->findOrFail($dish['id']);

            $ingredientCol = $dishObj->ingredients()
                ->findOrFail(collect($dish['ingredients'])->pluck('id')->toArray())
                ->keyBy('id');

            foreach ($dish['ingredients'] as $ingredient) {
                $attachIngredient[] = [
                    'dish_id' => $dish['id'],
                    'ingredient_id' => $ingredient['id'],
                    'amount' => $ingredient['amount']
                ];
                $ingredientPrice = $ingredientCol->get($ingredient['id'])->price;
                $price += $ingredientPrice * $ingredient['amount'];
            }
            $attachDish[$dish['id']] = [
                'menu_id' => $dish['menu_id'],
                'amount' => $dish['amount']
            ];
            $price += $dishObj->price * $dish['amount'];
        }

        $order = $request->user()->orders()->create([
            'price' => $price,
            'status' => 'pending'
        ]);

        $order->orderIngredients()->attach($attachIngredient);
        $order->dishes()->attach($attachDish);

        return OrderResource::make($order->load('dishes'));
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return OrderResource|array|Response
     */
    public function update(UpdateOrderRequest $request, $order)
    {
        $order = $request->user()->orders()->findOrFail($order);
        if ($order->status != 'pending'){
            return ResponseHelper::validation(['status' => __('validation.attributes.payed')]);
        }

        $attachIngredient = [];
        $attachDish = [];
        $price = 0;

        $menu = Menu::findOrFail(collect($request->dishes)->pluck('menu_id'))
            ->keyBy('id');

        foreach ($request->dishes as $dish) {

            $dishObj = $menu->get($dish['menu_id'])
                ->dishes()
                ->findOrFail($dish['id']);

            $ingredientCol = $dishObj->ingredients()
                ->findOrFail(collect($dish['ingredients'])
                    ->pluck('id')
                    ->toArray()
                )->keyBy('id');

            foreach ($dish['ingredients'] as $ingredient) {
                $attachIngredient[] = [
                    'dish_id' => $dish['id'],
                    'ingredient_id' => $ingredient['id'],
                    'amount' => $ingredient['amount']
                ];
                $ingredientPrice = $ingredientCol->get($ingredient['id'])->price;
                $price += $ingredientPrice * $ingredient['amount'];
            }
            $attachDish[$dish['id']] = [
                'menu_id' => $dish['menu_id'],
                'amount' => $dish['amount']
            ];
            $price += $dishObj->price * $dish['amount'];
        }
        $order->update([
            'price' => $price,
        ]);

        $order->orderIngredients()->sync($attachIngredient);
        $order->dishes()->sync($attachDish);

        return OrderResource::make($order->load('dishes'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
