<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductForm extends FormRequest
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
            'category_id' => 'required',
            'product_name' => 'required',
            'product_short_description' => 'required',
            'product_long_description' => 'required',
            'product_price' => 'required|numeric',
            'product_quantity' => 'required|numeric',
            'product_alert_quantity' => 'required|numeric',
            'product_photo' => 'image'
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'You must select a product category!'
        ];
    }
}
