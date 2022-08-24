<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SiteCategoryUpdateRequest extends FormRequest
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
            'site_id' => 'required|exists:sites,id',
            'place'   => 'required',
            'type'    => 'required',
            'status'  => 'required',
        ];
    }
    public function attributes()
    {
        return [
            'site_id'   => 'Site Adı',
            'place'     => 'Yer',
            'type'      => 'Növ',
            'status'    => 'Status',
            'image'     => 'Şəkil',
        ];
    }
}
