<?php

namespace App\Http\Requests\Admin\Dish;

use App\Menu;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'price' => 'required|numeric',//
            'type' => [
                'required',
                Rule::in(Menu::$type)
            ],
            'ingredients' => 'required|array',
            'ingredients.*' => 'required|array',
            'ingredients.*.id' => [
                'required',
                'integer',
                Rule::exists('ingredients', 'id'),
            ],
            'ingredients.*.quantity' => 'required|numeric',//
            'ingredients.*.is_necessary' => 'required|boolean',
        ];
    }
}
