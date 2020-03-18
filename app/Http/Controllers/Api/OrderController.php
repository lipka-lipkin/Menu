<?php

namespace App\Http\Controllers\Api;

use App\Dish;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\OrderStoreRequest;
use App\Http\Resources\Api\OrderResource;
use App\Ingredient;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

        $dishes = Dish::whereIn('id', collect($request->dishes)->pluck('id'))
            ->get()
            ->keyBy('id');

        $ingredientsId = [];
        $ingredientsArr = collect($request->dishes)->pluck('ingredients');
        foreach ($ingredientsArr as $ingredientsItem){
            foreach ($ingredientsItem as $ingredient){
                $ingredientsId[] = $ingredient['id'];
            }
        }
        $ingredients = Ingredient::whereIn('id', $ingredientsId)->get()->keyBy('id');

        foreach ($request->dishes as $dish) {

            $dishes->get($dish['id'])
                ->ingredients()
                ->wherePivot('is_necessary', false)
                ->findOrFail(
                    collect($dish['ingredients'])->pluck('id')
                )
            ;

            foreach ($dish['ingredients'] as $ingredient) {
                $attachIngredient[] = [
                    'dish_id' => $dish['id'],
                    'ingredient_id' => $ingredient['id'],
                    'amount' => $ingredient['amount']
                ];
                $ingredientPrice = $ingredients->get($ingredient['id']);
                $price += $ingredientPrice->price * $ingredient['amount'];
            }

            $attachDish[$dish['id']] = [
                'menu_id' => $dish['menu_id'],
                'amount' => $dish['amount']
            ];
            $dishPrice = $dishes->get($dish['id']);
            $price += $dishPrice->price * $dish['amount'];
        }

        $order = $request->user()->orders()->create([
            'price' => $price
        ]);

        $order->orderIngredients()->attach($attachIngredient);
        $order->dishes()->attach($attachDish);

        return OrderResource::make($order->load('dishes'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
