<?php

namespace App\Http\Middleware;

use App\Helpers\UserRole;
use Illuminate\Support\Facades\Auth;
use Closure;

class RoleManageProject
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
        if ( Auth::user()->hasRole(UserRole::SITE_MANAGER)
            AND !Auth::user()->manageProjects->contains($request->route()->id ?? $request->route()->project ?? null) 
        ) {
            return abort(403);
        }
        return $next($request);
    }
}
