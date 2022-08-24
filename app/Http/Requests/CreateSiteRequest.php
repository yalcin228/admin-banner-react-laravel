<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSiteRequest extends FormRequest
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
            'name' => 'required|max:64|min:3|string',
            'status' => 'required|boolean'
        ];
    }
    public function attributes()
    {
        return [
            'name'  => 'Sayt adı',
            'status'    => 'Status',
        ];
    }
}
