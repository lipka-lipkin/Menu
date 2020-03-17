<?php

namespace App\Http\Requests\Admin\Dish;

use App\Dish;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDishRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'price' => 'required|min:0.01|max:9999.99',
            'type' => [
                'required',
                Rule::in(Dish::$type)
            ],
            'ingredients' => 'required|array',
            'ingredients.*' => 'required|array',
            'ingredients.*.id' => [
                'required',
                'integer',
                Rule::exists('ingredients', 'id'),
            ],
            'ingredients.*.quantity' => 'required|integer',
            'ingredients.*.is_necessary' => 'required|boolean',
        ];
    }
}
