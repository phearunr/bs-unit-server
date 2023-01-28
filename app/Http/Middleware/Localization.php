<?php

namespace App\Http\Middleware;

use Closure;
use App;


class Localization
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
        $locale = '';
        if ( $request->wantsJson() ){
            $locale = $request->hasHeader('Accept-Language') ?? config('app.fallback_locale');
        } else {
            $locale = session()->get('locale', config('app.fallback_locale'));
        }
        App::setLocale( $locale );
        return $next($request);
    }
}
