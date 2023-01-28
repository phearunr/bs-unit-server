<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function showNotification(Request $request) 
    {       
    	return view('admin.notification.auth_user');
    }

    public function markAllAsRead(Request $request) 
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);
        return redirect()->back();
    }

    public function markAsRead(Request $request, $id)
    {
    	if ($request->ajax()){

    		$notification = Auth::user()->unreadNotifications->filter( function($item) use ($id) {
			    return $item->id == $id;
			})->first();

			if ( !$notification ) {
				abort(404);
			}
			
			try {
				$notification->markAsRead();
			} catch (\Exception $e) {
				return response()->json( ['error' => $e->getMessage() ] , 500 );
			}

    		return response()->json( ['status' => 'success', "message" => "Notification has been mark as read."] );
    	}

    	abort(404);
    }
}
