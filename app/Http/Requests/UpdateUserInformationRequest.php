<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserInformationRequest extends FormRequest
{

    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'user_profile_information';


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
            'name'              => 'required|string|min:6|max:191', 
            'phone_number'      => 'required|regex:^0\d{8,9}^|unique:users,phone_number,'.$this->id,          
            'email'             => 'nullable|email|unique:users,email,'.$this->id,
            'gender'            => 'in:Male,Female',
            'birthdate'         => "nullable|date|date_format:$date_format",
            'avatar'            => 'nullable|mimes:jpg,jpeg,png',
            'department_id'     => "nullable|exists:departments,id",
            'position'          => "nullable|string|max:200",
        ];
    }
}
