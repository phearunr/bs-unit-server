<?php

namespace App\Http\Controllers\ProjectCoordinator;

use App\Zone;
use App\Helpers\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZoneSiteEngineerController extends Controller
{
    protected $zone = null;
	
	public function __construct(Request $request)
	{		
		$this->zone = Zone::where('id', $request->zone_id)->first();
		
		// $this->middleware(function ($request, $next) {
		// 	if ( Auth::user()->manageProjects()->where('model_id', $this->zone->project_id)->count() == 0 ) { abort(403); }
		//     return $next($request);
		// });
	}
    public function index(Request $request){
        $zone = $this->zone;
		$site_engineers = $zone->managedUsers()
					  ->where('name', 'LIKE', "%$request->term%")
					  ->paginate();
	
       return view('project_coordinator.project.zone.site_engineer.index',compact('zone','site_engineers'));
    } 
}
