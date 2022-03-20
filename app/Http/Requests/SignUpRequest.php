<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'name'=>'required|string|max:255',
            'email'=> 'required|string|max:255|email|unique:users',
            'username'=>'required|string|max:255|unique:users|alpha_dash',
            'password' => 'min:8|required_with:c_password|same:c_password',
            'c_password' => 'min:8',
        ];
    }
}
