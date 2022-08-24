<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BannerCreateRequest extends FormRequest
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
            'site_id' => 'required|exists:sites,id',
            'category_id' => 'required|exists:site_categories,id',
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
