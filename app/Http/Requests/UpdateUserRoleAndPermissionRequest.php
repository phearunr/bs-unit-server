<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRoleAndPermissionRequest extends FormRequest
{
     /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'user_role_and_permission_setting';
    
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
            'role' => 'nullable|exists:roles,id',
            'managed_by' => 'nullable|exists:users,id',
            'projects' => 'nullable|array',
            'projects.*' => 'nullable|exists:projects,id',
        ];
    }
}
