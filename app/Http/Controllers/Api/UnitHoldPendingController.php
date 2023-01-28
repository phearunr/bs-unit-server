<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\UnitHoldRequest;
use App\Helpers\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitHoldPendingController extends Controller
{
    public function get(Request $request)
    {
    	$paginate = 25;
        $unit_hold_requests = UnitHoldRequest::query();
        $auth_user = User::findOrFail($request->user()->id);

 		if ( !$auth_user->hasRole(UserRole::UNIT_CONTROLLER) ) {
        	return abort(403);
        }

        $unit_hold_requests = $unit_hold_requests->scopeHoldPending(null);

        if ( $request->input("embed") ) {           
            $relationships = explode(',', trim($request->input('embed')) );
            return new UnitHoldRequestCollection( $unit_hold_requests->with($relationships)->paginate($paginate) ) ; 
        }

        return new UnitHoldRequestCollection( $unit_hold_requests->paginate($paginate) );
    }
}
