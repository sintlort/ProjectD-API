<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'=> 'required|unique:username|max:255',
            'password'=> 'required',
            'nama_user'=> 'required|max:255',
            'tgl_lahir'=> 'required',
            'gender'=> 'required',
            'alamat'=>'required|max:255',
            'email'=>'required|email|unique:email',
            'telp'=>'required|max:14',
        ];
    }
}
