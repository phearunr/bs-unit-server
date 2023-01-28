<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubConstructorRequest extends FormRequest
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
        $date_format = config('app.php_date_format');
        return [
            'name' => 'required|string|max:200',
            'join_date' => "required|date|date_format:$date_format",
            'avatar' => 'nullable|mimes:jpeg,jpg,png|max:1024',
            'worker' => 'required|integer|min:0',
            'contact' => 'array',
            'identity_document'=> 'array',
            'sub_constructor_skill' => 'array',
            'identity_document.*.attachment' =>'file', 
            'identity_document.*.type' => 'nullable|string',
            'identity_document.*.reference_no' => 'required|string|max:500',
            'identity_document.*.issue_date' => "required|date|date_format:$date_format",
            'identity_document.*.expiration_date' => "required|date|date_format:$date_format",
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'avatar.max' => 'Avatar must be less than or equal to 1MB ',
        ];
    }
}