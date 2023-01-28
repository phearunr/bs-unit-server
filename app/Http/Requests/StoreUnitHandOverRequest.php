<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitHandOverRequest extends FormRequest
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
            'unit_code'                 => 'required|string|max:250',
            'unit_id'                   => 'required|string|max:250',
            'date'                      => "required|date|date_format:$date_format",
            'appointment_image_url'     => 'required|mimes:pdf|max:10000',
            'handover_letter_image_url' => 'required|mimes:pdf|max:10000',
            'lor_image_url'             => 'required|mimes:pdf|max:10000',
            'customer_name'             => 'required|string|max:100',
            'customer_relationship'     => 'required|string|max:100',
            'agreement_date'            => "required|date|date_format:$date_format",
            'customer_name2'            => 'nullable|string|max:200',
            'customer_relationship2'    => 'nullable|string|max:200',
        ];
    }
}
