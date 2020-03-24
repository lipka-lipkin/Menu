<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dishes' => 'required|array',
            'dishes.*' => 'required|array',
            'dishes.*.id' => [
                'required',
                'integer',
                Rule::exists('dishes', 'id')
            ],
            'dishes.*.amount' => 'numeric|min:0.01|max:99.99',
            'dishes.*.menu_id' => [
                'required',
                'integer',
                Rule::exists('menus', 'id')
                    ->where(function($query){
                        $query->where('date', '>', now()->addDays(config('menu.menu_expired')));
                    }),
            ],
            'dishes.*.ingredients' => 'array',
            'dishes.*.ingredients.*' => 'array',
            'dishes.*.ingredients.*.id' => [
                'integer',
                Rule::exists('ingredients', 'id')
            ],
            'dishes.*.ingredients.*.amount' => 'numeric|min:0.01|max:99.99'
        ];
    }
}
