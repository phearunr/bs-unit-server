<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseRequest extends FormRequest
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
        return [
            'purchase_request_project_id' => 'exists:purchase_request_projects,id',
            'department_id' => 'exists:departments,id',
            'mrp_no' => 'nullable|string|max:100',
            'shipment_contact_name' => 'required|string|max:200',
            'shipment_contact_number' => 'required|string|max:100',
            'shipment_address_line1' => 'required|string|max:250',
            'shipment_address_line2' => 'nullable|string|max:200',
            'remark' => 'required|string|max:500',
            'purchase_request_details' => 'required|array',
            'purchase_request_details.*.item_code' => 'nullable|string|max:100',
            'purchase_request_details.*.description' => 'required|string|max:500',
            'purchase_request_details.*.unit_of_measurement' => 'required|string|max:100',
            'purchase_request_details.*.quantity' => 'required|numeric|min:1|max:9999999999.99',
            'purchase_request_details.*.expected_arrival_date' => 'required|string|max:100',
            'purchase_request_details.*.purpose' => 'required|string|max:100',
            'attachments' => 'nullable|array|max:5',
        ];
    }
}
