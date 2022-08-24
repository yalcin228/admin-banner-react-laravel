<?php

namespace App\Http\Requests;

use App\Enum\TypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'place' => 'required',
            'type' => 'required|in:'.TypeEnum::toString(','),
            'status' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'site_id'  => 'Sayt',
            'image'    => 'Şəkil',
            'place' => 'Yer',
            'type' => 'Tip',
            'status' => 'Status'
        ];
    }
}
