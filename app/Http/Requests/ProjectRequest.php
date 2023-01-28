<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{

    public function __construct(\Illuminate\Http\Request $request) 
    {
        if ( !$request->has('is_published') ) {
            $request->merge([ 'is_published' => false ]);
        } else {
            $request->merge([ 'is_published' => true ]);
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
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:200',
            'address' => 'nullable|string|max:200',
            'name_en' => 'required|string|max:200',
            'address_en' => 'nullable|string|max:200',
            'name_zh' => 'required|string|max:200',
            'address_zh' => 'nullable|string|max:200',
            'is_published' => 'required|boolean',
            'short_code' => 'required|string|max:200',
            'sale_representative_id' => 'required|exists:sale_representatives,id',
            'bank_id' => 'required|exists:banks,id', 
            'nav_company_code' => 'required|string|max:191',
            'logo_url' => 'nullable|dimensions:max_width=1000,ratio=1',
            'master_plan_url' => 'nullable'
        ];
    }
}
