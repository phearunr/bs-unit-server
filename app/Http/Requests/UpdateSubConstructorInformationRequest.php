<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubConstructorInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *per
     * @return bool
     */

    protected $errorBag = 'update_sub_constructor_profile_information';

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
