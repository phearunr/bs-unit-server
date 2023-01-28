<?php

namespace App\Http\Controllers\Api\Password;

use Validator;
use App\User;
use App\SmsPasswordReset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
	public function reset(Request $request)
	{
		$sms_password_reset = SmsPasswordReset::where('token', $request->token)
											  ->first();
		if ( !$sms_password_reset ) {
			return $this->sendErrorJsonResponse(__('Token mismatch!'), 422);   
		}

		$user = User::where('phone_number', $sms_password_reset->phone_number)->first();

		if ( !$user ) {
			return $this->sendErrorJsonResponse(__('User not found!'), 422);
		}

		$validator = Validator::make($request->only(['password']), [          
            'password'      => 'required|string|min:6|max:32'
        ]);

        if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        } 

		try {
			$user->password = bcrypt($request->password);
			$user->save();
			$sms_password_reset->delete();
			return $this->sendSuccessResponse( __("Your password has been reset successfully."), 200, []);
		} catch (\Exception $e) {
			return $this->sendErrorJsonResponse( __('Internal Server Error!'), 500);
		}
	}
}
