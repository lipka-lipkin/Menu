<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'dishes.*.id' => 'required|integer',
            'dishes.*.amount' => 'numeric|min:0.01|max:99.99',
            'dishes.*.menu_id' => 'required|integer',
            'dishes.*.ingredients' => 'array',
            'dishes.*.ingredients.*' => 'array',
            'dishes.*.ingredients.*.id' => 'integer',
            'dishes.*.ingredients.*.amount' => 'numeric|min:0.01|max:99.99'
        ];
    }
}
