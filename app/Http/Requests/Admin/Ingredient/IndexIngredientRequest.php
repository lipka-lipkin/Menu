<?php

namespace App\Http\Requests\Admin\Ingredient;

use Illuminate\Foundation\Http\FormRequest;

class IndexIngredientRequest extends FormRequest
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
            'search' => 'nullable|max:255',
            'from' => 'date',
            'to' => 'date'
        ];
    }
}
