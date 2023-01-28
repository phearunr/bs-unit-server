<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubConstructorIdentityDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $errorBag = 'sub_constructor_identity_document';

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
            'type' => 'required|string',
            'reference_no' => 'required|string|max:500',
            'issue_date' => "required|date|date_format:$date_format",
            'expiration_date' => "required|date|date_format:$date_format",
            'attachment' => 'nullable|file', 
        ];
    }
}
