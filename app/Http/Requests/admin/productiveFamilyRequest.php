<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class productiveFamilyRequest extends FormRequest
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
            'name' => 'required',
            'mobile' => 'required|unique:customers,mobile',
            "password" => "required|confirmed",
            'email' => 'required|email|unique:providers,email',
            'country_code' => 'required',
            'lat'=>'required',
            'lng'=>'required',
            'categories' => 'required|array|min:1'

        ];

        if($request->password){
            $rules["password"] = "required|confirmed";
        }
        return $rules;

    }

    public function messages()
    {
        return [
//            'title.required' => 'Title is required!',
//            'title_ar.required' => 'Title Ar is required!',
        ];
    }

}
