<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BannerUpdateRequest extends FormRequest
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
            'ads' => 'required',
            'site_id' => 'required',
            'category_id' => 'required',
            'status' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'site_id'       => 'Site Adı',
            'ads'           => 'Reklam',
            'category_id'   => 'Kateqoriya',
        ];
    }
}
