<?php

namespace App\Http\Requests\Admin\Ingredient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Ingredient;

class StoreIngredientRequest extends FormRequest
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
            'title' => 'required|max:255',
            'units' => [
                'required',
                Rule::in(Ingredient::$units)
            ],
            'price' => 'required|numeric|min:0.01|max:9999.99'
        ];
    }
}
