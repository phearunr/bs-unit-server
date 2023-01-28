<?php

namespace App\Http\Controllers\SiteEngineer;

use App\Unit;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ZoneUnitConstructionController extends Controller
{
	protected $zone = null;
   
   	public function __construct()
	{			
		$this->zone = Zone::find(request()->zone_id);
		$this->middleware(function ($request, $next) {			
			if ( Auth::user()->manageZones()->where('id', request()->zone_id)->count() == 0 ) { 
				abort(403); 
			}

		    return $next($request);
		});
	}

	public function show($zone_id, $unit_id) 
	{	
		$unit = $this->zone->units()->where('id', $unit_id)->firstOrFail();

		return view('site_engineer.zone.unit_construction.show', compact('unit'));
	}
}
