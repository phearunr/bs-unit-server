<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivity extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'user_id' => 'required|exists:users,id',
            'model_type' => 'required|string|max:191',
            'model_id' => 'required|string|max:191',
            'field_name' => 'required|string|max:191',
            'old_value' => 'required|string|max:191',
            'new_value' => 'required|string|max:191'
        ];
    }
}
