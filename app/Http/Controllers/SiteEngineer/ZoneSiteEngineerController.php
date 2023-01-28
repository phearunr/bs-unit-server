<?php

namespace App\Http\Controllers\SiteEngineer;

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
		
		$this->middleware(function ($request, $next) {
			if ( Auth::user()->manageZones()->where('model_id', $this->zone->id)->count() == 0 ) { abort(403); }

		    return $next($request);
		});
	}
    public function index(Request $request){
        $zone = $this->zone;
		$site_engineers = $zone->managedUsers()
					  ->where('name', 'LIKE', "%$request->term%")
					  ->paginate();

       	return view('site_engineer.zone.site_engineer.index',compact('zone','site_engineers'));

    }
}
