<?php

namespace App\Http\Requests\Api\Dish;

use Illuminate\Foundation\Http\FormRequest;

class StoreDishRequest extends FormRequest
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
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'is_necessary' => 'required|boolean',
            'ingredients' => 'required|array',
            'ingredients.*' => 'required|array',
            'ingredients.*.id' => 'required|integer'
        ];
    }
}
