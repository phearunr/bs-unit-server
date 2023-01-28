<?php

namespace App\Http\Controllers\SiteManager;

use App\Zone;
use App\Unit;
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
		
		return view('site_manager.project.zone.unit.index', compact('zone', 'units'));
	}

	public function associateUnitByCode(Request $request)
	{
		$zone_name = $this->zone->name;
        $unit = Unit::where('code', $request->unit_code)->firstOrFail(); 
        
        if  ( $unit && $unit->zone_id ) {        	
            return $this->sendErrorJsonResponse("Unit: [$unit->code] has been assigned to zone: [$zone_name]");
        }

        // check unit is in the project of the requested zone or not 
        if ( $this->zone->project->units()->where('units.id', $unit->id)->count() == 0 ) {
            abort(403);
        } 
        
        // Assign Unit To Zone
        $unit->zone()->associate($this->zone);
        $unit->save();

        // Return Response
        if ( $request->wantsJson() ) {
            return response()->json([
                'status' => __('success'), 
                'message' => "Unit [$unit->code] has been added to zone [$zone_name] successfully"
            ], 200);
        }
	}

	public function removeUnitFromZone(Request $request, $zone_id, $unit_id) 
	{
		$zone_name = $this->zone->name;
        $unit = Unit::where('id', $unit_id)->firstOrFail(); 
        
        // check unit is in the project of the requested zone or not 
        if ( $this->zone->project->units()->where('units.id', $unit->id)->count() == 0 ) {
            abort(403);
        } 
        
        // Assign Unit To Zone
        $unit->zone()->dissociate();
        $unit->save();

        // Return Response
        if ( $request->wantsJson() ) {
            return response()->json([
                'status' => __('success'), 
                'message' => "Unit [$unit->code] has been removed to zone [$zone_name] successfully."
            ], 200);
        }
	}
}
