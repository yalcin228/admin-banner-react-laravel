<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteApiRequest extends FormRequest
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
            'name'=> 'max:64|min:3|string',
            'status' => 'max:1|min:0|integer',
//            'id' => 'required|integer'
        ];
    }

    public function attributes()
    {
        return [
            'name'  => 'Ad Soyad',
            'status'    => 'Status',
            'id' => 'Identifikator'
        ];
    }
}
