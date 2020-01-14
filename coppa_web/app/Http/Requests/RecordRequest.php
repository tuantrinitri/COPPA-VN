<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordRequest extends FormRequest
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
            'long' => 'required',
            'weight' => 'required',
            'lat' => 'required',
            'lng' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'long.required' => 'Chưa nhập chiều dài',
            'weight.required' => 'Chưa nhập cân nặng',
            'lat.required' => 'Chưa nhập Lat',
            'lng.required' => 'Chưa nhập Lng'
        ];
    }
}
