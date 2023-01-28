<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteEngineerAccountSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @var string
     */

    protected $errorBag = 'site_engineer_account_setting';

    public function __construct(\Illuminate\Http\Request $request) 
    {
        if ( !$request->has('active') ) {
            $request->merge([ 'active' => false ]);
        } 

        if ( !$request->has('verified') ) {
            $request->merge([ 'verified' => false ]);
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
        return [
            'active' => 'required|boolean',
            'verified' => 'required|boolean',
        ];
    }
}
