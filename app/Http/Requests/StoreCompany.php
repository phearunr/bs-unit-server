<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompany extends FormRequest
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
            'name_km' => 'required|string|max:200',
            'address_line1' => 'nullable|string|max:200',
            'address_line2' => 'nullable|string|max:200',
            'name_en' => 'nullable|string|max:200',
            'address_line1_en' => 'nullable|string|max:200',
            'address_line2_en' => 'nullable|string|max:200',
            'name_zh' => 'nullable|string|max:200',
            'address_line1_zh' => 'nullable|string|max:200',
            'address_line2_zh' => 'nullable|string|max:200',
            'contact_phone_number' => 'nullable|string|max:200',
            'email_address' => 'nullable|email',
            'website' => 'nullable|url',
            'tax_no' => 'nullable|string|max:200',
            'tax_issued_date' => 'required|date|date_format:'.$date_format,
            'commercial_license_no' => 'nullable|string|max:200',
            'commercial_license_issued_date' => 'required|date|date_format:'.$date_format,
            'nav_company_code' => 'required|string|max:191'
        ];
    }
}
