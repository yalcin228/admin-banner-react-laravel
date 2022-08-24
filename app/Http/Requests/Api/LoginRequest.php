<?php

namespace App\Http\Requests\Api;

use App\Rules\CheckPasswordRule;
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username'    => 'required|exists:users,username',
            'password'    => ['required','string','min:4', new CheckPasswordRule(request()->username)]
        ];
    }

    public function attributes()
    {
        return [
            'username'      => 'İstifadəçi adı',
            'password'      => 'Şifrə',
        ];
    }
}
