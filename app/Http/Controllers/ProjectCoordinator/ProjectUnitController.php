<?php

namespace App\Http\Controllers\ProjectCoordinator;

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
	}

	public function index(Request $request,$id)
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
		$project = $this->project;

		return view('project_coordinator.project.unit.index', compact('units', 'statuses' ,'unit_types', 'zones', 'project'));
	}

	public function show(Request $request, $project_id, $unit_id)
	{		
		$unit = Project::where('id', $project_id)->firstOrFail()
		->units()
		->where('units.id', $unit_id)
		->firstOrFail();
		return view('project_coordinator.project.unit.single', compact('unit'));
	}
}