<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ZoneRequest extends FormRequest
{
   
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        if ( $user->manageProjects->contains('id', $this->project_id) ) {
            return true;
        }
        return false;
      
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_id' => 'required',
            'name' => [
                'required', 
                 Rule::unique('zones')
                       ->ignore($this->zone)
                       ->where('project_id', $this->project_id)
               ]
            //'required|string|max:200|unique:zones,name,{$this->zone->project_id}}',
        ];
    }
}
