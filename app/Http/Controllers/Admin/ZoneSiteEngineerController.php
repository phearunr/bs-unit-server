<?php

namespace App\Http\Controllers\Admin;

use App\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZoneSiteEngineerController extends Controller
{
	protected $zone = null;

	public function __construct(Request $request)
	{		
		$this->zone = Zone::where('id', $request->zone_id)->firstOrFail();
		
		$this->middleware(function ($request, $next) {
			// if ( Auth::user()->hasRole([UserRole::ADMINISTRATOR]) ) { 
			// 	return $next($request); 
			// }

			// if ( Auth::user()->manageProjects()->where('model_id', $this->zone->project_id)->count() == 0 ) { abort(403); }

		 	return $next($request);
		});
	}

    public function index(Request $requst)
    {
    	$zone = $this->zone;
		$users = $zone->managedUsers()
					  ->with('roles')
					  ->paginate();

		return view('admin.zone.site_engineer.index', compact('zone', 'users'));
    }
}
