<?php

namespace App\Http\Controllers\Admin;

use App\Zone;
use App\Helpers\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZoneUnitController extends Controller
{
	protected $zone = null;
	
	public function __construct(Request $request)
	{		
		$this->zone = Zone::where('id', $request->zone_id)->first();
		
		$this->middleware(function ($request, $next) {
			if ( Auth::user()->hasRole([UserRole::ADMINISTRATOR]) ) { 
				return $next($request); 
			}

			if ( Auth::user()->manageProjects()->where('model_id', $this->zone->project_id)->count() == 0 ) { abort(403); }

		    return $next($request);
		});
	}

	public function index(Request $request)
	{
		$zone = $this->zone;
		$units = $zone->units()
					->where('code', 'LIKE', "%$request->term%")
					->paginate();
		return view('admin.zone.unit.index', compact('zone', 'units'));
	}
}
