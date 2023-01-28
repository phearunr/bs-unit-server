<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteEngineerManagedZoneRequest extends FormRequest
{   
     /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'site_engineer_manage_zone_setting';

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
            'zones' => 'required|array',
            'zones.*' => 'required|exists:zones,id',
        ];
    }
}
