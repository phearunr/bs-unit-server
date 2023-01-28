<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\User;
use App\Helpers\UserRole;
use App\Notifications\UserVerified;
use App\Notifications\UserUnverified;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifyUserController extends Controller
{
    public function verifyRequest(Request $request, $id)
    {
    	$auth_user = $request->user();
    	$user = User::findOrfail($id);
        $user_phone_number = $user->getKhFormattedPhoneNumber();
        $is_verified = false;

    	if ( !$auth_user->hasRole(UserRole::SALE_TEAM_LEADER) ) {
    		return $this->sendErrorJsonResponse( __("You don't have permission to process your request") , 422);
    	}

    	if ( $user->managed_by != $auth_user->id ) {
    		return $this->sendErrorJsonResponse( __("You don't have permission to process your request") , 422);
    	}

    	if ( $user->verified ) {
    		return $this->sendErrorJsonResponse( __("This user no need to be verified.") , 422);	
    	}

        $validator = Validator::make($request->only('status'),[
            'status' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

		try {
            if ( $request->status ) {
                if ( $this->verify($user) ) {
                    // Notify the user                   
                    $user->notify(New UserVerified($user));
                    // Log to notification (Slack)
                    Log::channel('slack')->info("User {$user->name} ({$user->phone_number}) has verified.");
                    return $this->sendSuccessResponse( __("The user is now verified.") , 200);
                } else {
                    return $this->sendErrorJsonResponse( __("Internal Server Error!"), 500);
                }
            } else {
                if ($this->unverify($user)) {
                    // Notify the user                  
                    Notification::route('twilio', $user_phone_number)->notify(new UserUnverified());                 
                    // Log to notification (Slack)
                    Log::channel('slack')->warning("User {$user->name} ({$user->phone_number}) has unverified.");
                    return $this->sendSuccessResponse( __("The user is now unverified.") , 200);
                } else {
                    return $this->sendErrorJsonResponse( __("Internal Server Error!"), 500);
                }
            }
		} catch (\Exception $e) {
			return $this->sendErrorJsonResponse( $e->getMessage(), 500);
		} 
    }

    protected function verify(User $user) 
    {
        $user->verified = true;     
        return $user->save();
    }

    protected function unverify(User $user)
    {    
        return $user->delete();
    }
}
