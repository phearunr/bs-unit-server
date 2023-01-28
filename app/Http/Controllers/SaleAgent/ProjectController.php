<?php

namespace App\Http\Controllers\SaleAgent;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
	protected $view_prefix = 'sale_agent.';

	public function index(Request $request)
	{
		$projects = Project::with(['unitTypes'])
					->ofPublished(true)
					->paginate();
		return view($this->view_prefix.'project.index', compact('projects'));
	}

	public function showMasterPlan($id) 
	{
		$project = Project::findOrFail($id); 
        return view($this->view_prefix.'project.master_plan', compact('project'));
	}
}
