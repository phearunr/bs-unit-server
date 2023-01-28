<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
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
            'url' => 'required|url|max:191',
            'order' => 'required|integer|min:0',
            'expired_at' => "required|date|date_format:$date_format",
            'image_url' => 'required|dimensions:min_width=1024'
        ];
    }
}
