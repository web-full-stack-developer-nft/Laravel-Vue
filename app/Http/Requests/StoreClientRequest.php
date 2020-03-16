<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'name' => 'required',
            'phone' => 'required|unique:clients|max:11|min:11',
            'email' => 'required|email|unique:clients'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Client name is required',
            'email.required'  => 'Client email is required',
            'phone.required'  => 'Client Contact no. is required',

            'phone.unique' => 'Contact no. is already exists',
            'email.unique' => 'E-mail is already exists',

            'phone.max' => 'Invalid contact no.',
            'phone.min' => 'Invalid contact no.',

            'email.email' => 'Invalid email',
        ];
    }
}
