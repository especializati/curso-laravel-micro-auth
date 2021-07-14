<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUser extends FormRequest
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
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'password' => ['required', 'min:4', 'max:16'],
            'email' => ['required', 'email', 'max:255'],
        ];

        if ($this->method() == 'PUT') {
            $rules['password'] = ['nullable', 'min:4', 'max:16'];
        }

        return $rules;
    }
}
