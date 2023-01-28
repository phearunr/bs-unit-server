<?php

namespace App\Http\Controllers\SiteEngineer;

use App\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZoneUnitController extends Controller
{
	public function index(Request $request, $id) 
	{
		if ( request()->user()->manageZones()->where('id', $id)->count() == 0 ) {
    		abort(403);
    	}

        $zone = Zone::findOrFail($id);
        $units = $zone->units()
        ->when( $term = request()->term, function($query, $term) {
            return $query->where('code', 'LIKE', "%$term%");
        })
        ->paginate();
      
   		return view('site_engineer.zone.single', compact('zone', 'units'));
	}
}
