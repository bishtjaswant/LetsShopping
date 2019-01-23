<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileUsers extends FormRequest
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
             "name" => "required"
              // "slug" => 
              "email" => "required|email|unique:users",
              "password" => "required|min:4|max:10|confirmed:password_confirm",
              "password_confirm" => "required",
              "status" => "required|integer",
              "role_id" => "required|integer",
              "address" =>  "required|max:450",
              "country_id" => "required|integer",
              "state_id" => "required|integer",
              "city_id" => "required|integer",
              "phone" => "required|numeric|size:10",
        ];
    }
}
