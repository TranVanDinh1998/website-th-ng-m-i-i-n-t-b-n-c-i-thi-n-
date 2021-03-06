<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            //
            'name' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:500000',
            'quantity' => 'required|min:0',
            'type' => 'required|min:0|max:1',
            'minimum_order_value' => 'required|min:0',
        ];
    }
}
