<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class advertisingRequest extends FormRequest
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
        return  [
            'title'    => 'required',
            'title_ar' => 'required',
            'image'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' =>'required',
            'expiry_date' =>'required',
            'provider_id'  => 'required|exists:App\Models\Provider,id'

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
