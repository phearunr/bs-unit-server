<?php

namespace App\Traits;

use App\User;
use App\Notifications\UserActivated;
use App\Notifications\UserDeactivated;
use Illuminate\Support\Facades\Log;

trait UserActiveStatusNotification
{
	public function sendUserActiveStatusNotification(User $user)
	{		
		try {
			if ( $user->active ) {
	            $user->notify(New UserActivated($user));
	        } else {
	            $user->notify(New UserDeactivated($user));
	        }
		} catch (\Exception $e) {
			Log::error($e->getMessage());
		}
	}
}