<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
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
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'description' => 'max:255',
            'code_alpha2' => 'alpha|max:2',
            'image' => 'max:255',
            'image_show' => 'boolean',
            'meta_title' => 'max:255',
            'meta_description' => 'max:255',
            'meta_keywords' => 'max:255',
            'published' => 'boolean',
            'created_by' => 'integer',
            'modified_by' => 'integer',
        ];
    }

    public function messages()
    {
        return parent::messages();
    }

}
