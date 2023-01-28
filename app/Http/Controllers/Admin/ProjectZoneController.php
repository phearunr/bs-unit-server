<?php

namespace App\Http\Controllers\Admin;

use App\Zone;
use App\Helpers\UserRole;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProjectZoneController extends Controller
{	
	protected $project = null;

	public function __construct(Request $request)
	{		
		$this->project = \App\Project::where('id', $request->project_id)
									 ->first();
		
		$this->middleware(function ($request, $next) {
			if ( Auth::user()->hasRole([UserRole::ADMINISTRATOR]) ) { return $next($request); }

			if ( Auth::user()->manageProjects()->where('model_id', $this->project->id)->count() == 0 ) { abort(403); }

		    return $next($request);
		});
	}

	public function index(Request $request) 
	{
		abort(404);
	}

	public function show(Request $request, $project_id, $id)
	{
		abort(404);
	}

    public function create()
    {       
    	$project = $this->project;
    	return view('admin.project.zone.new', compact('project'));
    }

    public function store(Request $request)
    {	
    	$validatedData = $request->validate([
	       'name' => [
            	'required', 
            	Rule::unique('zones')                   	
                   	->where('project_id', $this->project->id)
           ]
	    ]);

   		$zone = $request->user()->zones()->create(
   			array_merge( $validatedData, ['project_id' => $this->project->id] )
		);

   		 return redirect()->route('admin.zones.units.index', [ 	    	
	    	'id' => $zone->id
	    ])->with('status', "Zone has been created successfully.");
    }

    public function edit($project_id, $id) {
    	$zone = Zone::where('id', $id)->firstOrFail();

    	return view('admin.project.zone.edit', compact('zone'));
    }

    public function update(Request $request, $project_id, $id)
    {
    	$zone = Zone::findOrFail($id);

    	$validatedData = $request->validate([
	       	'name' => [
            	'required', 
            	Rule::unique('zones')                   	
                   	->where('project_id', $this->project->id)
          	]
	    ]);

	    $zone->name = $validatedData['name'];

	    $request->user()->zones()->save($zone);

	    return redirect()->route('admin.projects.zones.edit', [ 
	    	'project_id' => $zone->project->id,
	    	'id' => $zone->id
	    ])->with('status', "Zone has been updated successfully.");
    }
}
