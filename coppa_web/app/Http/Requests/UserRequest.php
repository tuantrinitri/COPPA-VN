<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $data = $this->only(['id', 'btnSave']);
        if ($data['btnSave'] == 'add') {
            return [
                'username' => 'required|min:4|unique:users,username',
                'password' => 'required',
                'repassword' => 'required|same:password',
                'email' => 'required|email|unique:users,email'
            ];
        } else {
            return [
                'username' => [
                    'required',
                    'min:4',
                    Rule::unique('users')->ignore($data['id']),
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($data['id']),
                ],
                'repassword' => [
                    'required_with:password',
                    'same:password'
                ]
            ];
        }
    }

    public function messages()
    {
        return [
            'username.required' => 'Chưa nhập tài khoản',
            'username.min' => 'Tài khoản quá ngắn',
            'username.unique' => 'Tài khoản đã tồn tại',
            'email.required' => 'Chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Chưa nhập mật khẩu',
            'repassword.required' => 'Chưa nhập lại mật khẩu',
            'repassword.required_with' => 'Chưa nhập lại mật khẩu mới',
            'repassword.same' => 'Hai mật khẩu không khớp'
        ];
    }
}
