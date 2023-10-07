<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:25',
            'title_ar' => 'required|string|max:25',
            'description' => 'required|string|max:100',
            'description_ar' => 'required|string|max:100',
            'category_id' => 'required|exists:App\Models\Category,id',
            'provider_id' => 'required|exists:App\Models\Provider,id',
            'prepare_time' => 'required|numeric|min:0',
             'images' => 'max:5',
            
            // Add more validation rules as needed
        ];
    }

    public function messages()
    {
        return [
//            'title.required' => 'Title is required!',
//            'title_ar.required' => 'Title Ar is required!',
        ];
    }
}
