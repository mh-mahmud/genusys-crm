<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'first_name'            => 'required|string|max:50|min:2',
            'middle_name'           => 'nullable|string|max:50|min:2',
            'last_name'             => 'nullable|string|max:50|min:2',
            'email'                 => 'required|email|string|max:60|unique:users',
            'phone'                 => 'nullable|numeric|digits_between:10,15|unique:users',
            // 'user_name'             => 'required|string|max:50|min:3',
            'password'              => 'required|confirmed|min:6'
        ];
    }
}
