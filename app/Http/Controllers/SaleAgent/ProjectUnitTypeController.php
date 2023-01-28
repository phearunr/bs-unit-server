<?php

namespace App\Http\Controllers\SaleAgent;

use App\UnitType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectUnitTypeController extends Controller
{

	protected $project = null;

	public function __construct(Request $request)
	{		
		$this->project = \App\Project::where('id', $request->project_id)->first();
	}

    public function index(Request $request)
    {
    	$unit_types = $this->project->unitTypes();

    	if ( $request->wantsJson() ) {
    		return $unit_types->get();
    	}
    	abort(404);
    }
}
