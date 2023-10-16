<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class categoryRequest extends FormRequest
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
            'title' => 'required',
            'title_ar' => 'required',
            'description'=>'required',
            'description_ar'=>'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif',
            'country'=>'required'

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
