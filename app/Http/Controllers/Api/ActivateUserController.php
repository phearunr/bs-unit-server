<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\User;
use App\Helpers\UserRole;
use App\Notifications\UserActivated;
use App\Notifications\UserDeactivated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivateUserController extends Controller
{
    public function activateRequest(Request $request, $id) 
    {
        $auth_user = $request->user();
        $user = User::findOrfail($id);

        if ( !$auth_user->hasRole(UserRole::SALE_TEAM_LEADER) ) {
            return $this->sendErrorJsonResponse( __("You don't have permission to process your request") , 422);
        }

        if ( $user->managed_by != $auth_user->id ) {
            return $this->sendErrorJsonResponse( __("You don't have permission to process your request") , 422);
        }

        $validator = Validator::make($request->only('status'),[
            'status' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

        try {
            $user->active = $request->status;
            $status_string  = $request->status ? 'activated' : 'deactivated';
            
            if ( !$user->isDirty('active') ) {                
                return $this->sendErrorJsonResponse( __("The user was already {$status_string}.") , 422);
            }

            $user->save();

            if ( $request->status ) {
                $user->notify(New UserActivated($user));
            } else {
                $user->notify(New UserDeactivated($user));
            }

            return $this->sendSuccessResponse( __("The user is now {$status_string}.") , 200);
        } catch (\Exception $e) {
            if ( config('app.env') == 'production' ) {
                return $this->sendErrorJsonResponse( __("Internal Server Error!") , 500);	
            } else {
                return $this->sendErrorJsonResponse( $e->getMessage() , 500);	
            }
        } 
    }
}
