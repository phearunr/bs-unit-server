<?php

namespace App\Http\Controllers\SiteManager;

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
    	return view('site_manager.project.zone.new', compact('project'));
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

   		 return redirect()->route('site_manager.zones.units.index', [ 	    	
	    	'zone_id' => $zone->id
	    ])->with('status', "Zone has been created successfully.");
    }

    public function edit($project_id, $id) {
    	$zone = Zone::where('id', $id)->firstOrFail();

    	return view('site_manager.project.zone.edit', compact('zone'));
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

	    return redirect()->route('site_manager.projects.zones.edit', [ 
	    	'project_id' => $zone->project->id,
	    	'id' => $zone->id
	    ])->with('status', "Zone has been updated successfully.");
    }
}
