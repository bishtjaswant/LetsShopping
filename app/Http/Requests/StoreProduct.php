<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
              "title" => 'required|min:5|max:40',
              "slug" =>  'required|max:55',
              "description" => 'required|max:500',
              "price" => 'required',
              // "discount_price" => '',
              // "extras" => 'required|array' ,
              "status" => 'required',
              "category_id" => 'required',
              "thumbnail" => 'required|mimes:jpeg,jpg,png|max:3048',
          ];
    }
}
