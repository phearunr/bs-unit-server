<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MarkNotificationAsRead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if($request->has('read')) {
            $user = $request->user() ?? $request->user('web') ?? $request->user('api');           
            if ( $user ) {
                $notification = $user->notifications()
                                     ->where('id', $request->read)
                                     ->first();
                if( $notification ) {
                    $notification->markAsRead();
                }
            } 
        }
        return $next($request);
    }
}
