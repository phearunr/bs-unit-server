<?php

namespace App\Http\Middleware;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Closure;

class CheckPasswordExpired
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
        $user = Auth::user();
        
        if( $user instanceof User ) {
            if ( $user->password_expired_at != null 
                AND $user->password_expired_at->lessThan(now()) ) {

                return redirect()->route('password.change');
            }
        }
        return $next($request);
        
    }
}
