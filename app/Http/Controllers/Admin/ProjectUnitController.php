<?php

namespace App\Http\Controllers\Admin;

use App\Unit;
use App\Project;
use App\Helpers\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectUnitController extends Controller
{
	protected $project = null;

	public function __construct(Request $request)
	{		
		$this->project = \App\Project::where('id', $request->project_id)
									 ->first();
		
		$this->middleware(function ($request, $next) {
			if ( Auth::user()->hasRole([UserRole::ADMINISTRATOR, UserRole::UNIT_CONTROLLER]) ) { return $next($request); }

			if ( Auth::user()->manageProjects()->where('model_id', $this->project->id)->count() == 0 ) { abort(403); }

		    return $next($request);
		});
	}

   	public function index(Request $request)
   	{
		$units = $this->project->units()
		->when($term = $request->input('term'), function($query, $term) {
			return $query->where('code', 'LIKE' ,"%$term%");
		})
		->when($status = $request->input('status'), function($query, $status) {
			return $query->whereHas('action', function ($sub_query) use ($status){
				$sub_query->where('action', $status);
			});
		})
		->when($unit_type_id = $request->input('unit_type_id'), function($query, $unit_type_id) {
			return $query->where('unit_type_id', $unit_type_id);
		})
		->when($zone_id = $request->input('zone_id'), functioN ($query, $zone_id) {
			return $query->where('zone_id', $zone_id);
		})
		->with('zone')
		->paginate();

		$statuses = \App\Helpers\UnitStatus::getUnitStatuses();
		$unit_types = $this->project->unitTypes;
		$zones = $this->project->zones;
		return view('admin.project.unit.index', compact('units', 'statuses' ,'unit_types', 'zones'));
   	}
}
