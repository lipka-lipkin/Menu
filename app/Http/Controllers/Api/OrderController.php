<?php

namespace App\Http\Controllers\Api;

use App\Dish;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\OrderStoreRequest;
use App\Http\Requests\Api\Order\UpdateOrderRequest;
use App\Http\Resources\Api\OrderResource;
use App\Order;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $orders = $request->user()->orders()->paginate();
        return OrderResource::collection($orders);
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

        foreach ($request->dishes as $dish) {
            $dishObj = Dish::whereHas('menu', function ($query) use ($dish){
                $query->where('date', '>', now()->addDays(config('menu.menu_expired')))
                    ->where('id', $dish['menu_id']);
            })->whereHas('ingredients', function ($query) use ($dish){
                $query->where('dish_ingredient.is_necessary', false)
                    ->whereIn('ingredient_id', collect($dish['ingredients'])->pluck('id'));
            })->find($dish['id']);

            foreach ($dish['ingredients'] as $ingredient) {
                $attachIngredient[] = [
                    'dish_id' => $dish['id'],
                    'ingredient_id' => $ingredient['id'],
                    'amount' => $ingredient['amount']
                ];
                $ingredientPrice = $dishObj->ingredients()
                    ->find($ingredient['id'])
                    ->price;
                $price += $ingredientPrice * $ingredient['amount'];
            }
            $attachDish[$dish['id']] = [
                'menu_id' => $dish['menu_id'],
                'amount' => $dish['amount']
            ];
            $price += $dishObj->price * $dish['amount'];
        }
        $order = $request->user()->orders()->create([
            'price' => number_format($price, 2, '.', ''),
            'status' => 'pending'
        ]);

        $order->orderIngredients()->attach($attachIngredient);
        $order->dishes()->attach($attachDish);

        return OrderResource::make($order->load('dishes'));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Order $order
     * @return OrderResource
     */
    public function show(Request $request, $order)
    {
        $order = $request->user()->orders()->findOrFail($order);
        return OrderResource::make($order->load('dishes'));
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

        foreach ($request->dishes as $dish) {
            $dishObj = Dish::whereHas('menu', function ($query) use ($dish){
                $query->where('date', '>', now()->addDays(config('menu.menu_expired')))
                    ->where('id', $dish['menu_id']);
            })->whereHas('ingredients', function ($query) use ($dish){
                $query->where('dish_ingredient.is_necessary', false)
                    ->whereIn('ingredient_id', collect($dish['ingredients'])->pluck('id'));
            })->find($dish['id']);

            foreach ($dish['ingredients'] as $ingredient) {
                $attachIngredient[] = [
                    'dish_id' => $dish['id'],
                    'ingredient_id' => $ingredient['id'],
                    'amount' => $ingredient['amount']
                ];
                $ingredientPrice = $dishObj->ingredients()
                    ->find($ingredient['id'])
                    ->price;
                $price += $ingredientPrice * $ingredient['amount'];
            }
            $attachDish[$dish['id']] = [
                'menu_id' => $dish['menu_id'],
                'amount' => $dish['amount']
            ];
            $price += $dishObj->price * $dish['amount'];
        }
        $order->update([
            'price' => number_format($price, 2, '.', ''),
        ]);

        $order->orderIngredients()->sync($attachIngredient);
        $order->dishes()->sync($attachDish);

        return OrderResource::make($order->load('dishes'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Order $order
     * @return array|ResponseFactory|Response
     */
    public function destroy(Request $request, $order)
    {
        $order = $request->user()->orders()->findOrFail($order);
        if ($order->status != 'pending'){
            return ResponseHelper::validation(['status' => __('validation.attributes.payed')]);
        }
        $order->delete();
        return ['status' => 'ok'];
    }
}
