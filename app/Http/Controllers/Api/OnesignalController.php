<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OnesignalController extends Controller
{
    public function updateAuthUserPlayerId(Request $request)
    {   
        $validator = Validator::make($request->only(['player_id']), [
                'player_id'  => 'required|string|size:36'
            ] 
        );
        if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }
    	try {
    		$token = $request->user()->token();            
    		$token->onesignal_player_id = $request->player_id;
    		if ( ! $token->save() ){
    			return $this->sendErrorJsonResponse( __("Internal Server Error!"), 500 );	
    		}
    		return $this->sendSuccessResponse( __("Player Id has been saved successfully") , 200);
    	} catch (\Exception $e) {
    		return $this->sendErrorJsonResponse( __("Internal Server Error!"), 500 );
    	}    
    }
}
