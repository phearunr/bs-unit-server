<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserAccountStatus
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
        if ( Auth::check() ) {
            if ( !Auth::user()->active ) {
                Auth::logout();
                return redirect()->route('login')
                                 ->withErrors(['inactive_user' => 'Your account has been deactivated.']);
            }
        }
        return $next($request);
    }
}
