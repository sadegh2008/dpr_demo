<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize () {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules () {
        return [
            'role'     => 'required|exists:roles,name',
            'name'     => 'required|string|min:3',
            'family'   => 'nullable|string',
            'password' => 'required|confirm',
            'email'    => 'require_without:mobile|email',
            'mobile'   => 'require_without:email|string|digits:11',
        ];
    }
}
