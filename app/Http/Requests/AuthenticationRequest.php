<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class AuthenticationRequest extends FormRequest
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
            'fullname'  => 'required|string',
            'identity'  => 'required',/*unique:certifications,idCard*/
            'address'   => 'required',
            'phone'     => 'required|regex:/^[0-9]{1,6}-[0-9]{5,11}$/',
            'birth'     => 'required|date',
            'photo'     => 'required|mimes:jpeg,bmp,png,gif,jpg|dimensions:min_width=200,min_height=200',
        ];
    }
}
