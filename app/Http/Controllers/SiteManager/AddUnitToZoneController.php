<?php

namespace App\Http\Controllers\SiteManager;

use App\Unit;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AddUnitToZoneController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $zone = Zone::findOrFail($request->zone_id);
        $unit = Unit::findOrFail($id);       

        // check user manage the zone or not
        if ( Auth::user()->manageProjects()->where('model_id', $zone->project->id)->count() <= 0 ) {
            abort(403);
        }
        
        // check unit is in the project of the requested zone or not 
        if ( $zone->project->units()->where('units.id', $unit->id)->count() <= 0 ) {
            abort(403);
        } 
        if( Auth::user()->hasRole("site_manager") ){
             // Assign Unit To Zone
            $unit->zone()->associate($zone);
            $unit->save();

            // Return Response
            if ( $request->wantsJson() ) {
                return response()->json([
                    'status' => __('success'), 
                    'message' => "Unit [$unit->code] has been added to zone [$zone->name] successfully"
                ], 200);
            }
        }
        else {
            abort(403);
        }
    }
}
