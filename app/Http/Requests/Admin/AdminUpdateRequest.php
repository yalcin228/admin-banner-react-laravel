<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'          => 'required|string',
            'username'      => 'required|string|unique:users,username,'.$this->id,
            'email'         => 'required|email|unique:users,email,'.$this->id,
            'phone'         => 'required|digits:10|unique:users,phone,'.$this->id,
            'password'      => 'sometimes',
            'status'        => 'required',
            'is_outside'    => 'required',
            'roles' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name'  => 'Ad Soyad',
            'email' => 'Email address',
            'username' => 'İstifadəçi adı',
            'phone'    => 'Nömrə',
            'password'  => 'Şifrə',
            'status'    => 'Status',
            'is_outside' => 'Kənardan giriş',
        ];
    }
}
