<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'username' => 'required|min:3',
            'password' => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Chưa nhập tài khoản',
            'username.min' => 'Hãy nhập một tài khoản hợp lệ',
            'password.required' => 'Chưa nhập mật khẩu',
            'password.min' => 'Hãy nhập mật khẩu hợp lệ'
        ];
    }
}
