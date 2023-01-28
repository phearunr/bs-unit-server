<?php

namespace App\Http\Controllers\Admin;

use App\UnitAction;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class UnitActionController extends Controller
{
    public function index(Request $request)
    {
    	$unit_actions = UnitAction::query();
    	$unit_actions = $unit_actions->with(['unit','unit.unitType', 'unit.unitType.project']);
    	$actions = UnitAction::getActionList();

    	$projects = Project::with('unitTypes')->get();

    	$from  = Carbon::today();
    	$to    = Carbon::today()->addSeconds(86399);

    	if ( $request->input('from') ) {
    		$from = Carbon::createFromFormat(config('app.php_date_format'),$request->input('from'))->startOfDay();
    	}

    	if ( $request->input('to') ) {
    		$to = Carbon::createFromFormat(config('app.php_datetime_format'),$request->input('to').' 23:59:59');
    	}

    	if ( $request->input('term') ) {
    		$term = $request->input('term');
    		$unit_actions = $unit_actions->whereHas('unit', function ($query) use ($term)  {
				$query->where('code', 'LIKE', '%'.$term.'%');
			});  
    	}

    	if ( $request->input('unit_type') ) {
    		$unit_actions = $unit_actions->byUnitType($request->input('unit_type'));
    	}

    	if ( $request->input('action') ) {
    		$unit_actions = $unit_actions->where('action',$request->input('action'));
    	}

    	$unit_actions = $unit_actions->whereBetween('created_at',[$from, $to]);

        $unit_actions = $unit_actions->paginate(20);       

        return view('admin.unit_action.index', compact('unit_actions','projects','actions'));
    }
}
