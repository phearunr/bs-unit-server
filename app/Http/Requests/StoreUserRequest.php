<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function __construct(\Illuminate\Http\Request $request) 
    {
        if ( !$request->has('active') ) {
            $request->merge([ 'active' => false ]);
        } 

        if ( !$request->has('verified') ) {
            $request->merge([ 'verified' => false ]);
        }

        if ( !$request->has('need_change_password') ) {
            $request->merge([ 'need_change_password' => false ]);
        }
    }

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
            'phone_number'      => 'required|regex:^0\d{8,9}^|unique:users,phone_number',
            'password'          => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'email'             => "nullable|email|unique:users,email",
            'gender'            => 'in:Male,Female',
            'birthdate'         => "nullable|date|date_format:$date_format",
            'managed_by'        => "nullable|exists:users,id",
            'department_id'     => "nullable|exists:departments,id",
            'position'          => "nullable|string|max:200",
            'avatar'            => 'nullable|image',
            'identification_id' => 'exists:user_identifications,id',
            'active'            => 'nullable|boolean',
            'verified'          => 'nullable|boolean',
            'need_change_password' => 'nullable|boolean'
        ];
    }
    
}
