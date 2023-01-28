<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\NotificationCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
	public function index(Request $request)
	{
		$per_page = 10;
        return new NotificationCollection(
            Auth::user()
                ->notifications()
                ->simplePaginate($request->query('per_page') ??  $per_page)
        );
	}

	public function update($id = null)
	{		
		try {
			if ( $id ) {	
				Auth::user()->notifications()
							->where('id', $id)
							->first()
							->markAsRead();					
			} else {				
				Auth::user()->unreadNotifications->markAsRead();
			}
			return response()->json([],204);
		} catch (\Exception $e) {
			Log::error($e->getMessage());
            return $this->sendErrorJsonResponse( __("Internal System Error!"), 500);
		}
	}
}
