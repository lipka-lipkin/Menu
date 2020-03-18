<?php

namespace App\Http\Requests\Admin\Menu;

use App\Menu;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMenuRequest extends FormRequest
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
            'date' => 'required|date_format:Y-m-d',
            'dishes' => 'required|array',
            'dishes.*' => 'required|array',
            'dishes.*.id' => [
                'required',
                'integer',
                Rule::exists('dishes', 'id')
            ],
        ];
    }
}
