<?php

namespace App\Http\Requests\Api\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Menu;

class StoreMenuRequest extends FormRequest
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
            'type' => [
                'required',
                'string',
                Rule::in(Menu::$type)
            ],
            'dishes' => 'required|array',
            'dishes.*' => 'required|array',
            'dishes.*.id' => 'required|integer',//exists
        ];
    }
}
