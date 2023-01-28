<?php

namespace App\Http\Controllers;

use App\Helpers\UserRole;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = null;
        if ($request->user()->hasRole(UserRole::ADMINISTRATOR)) {
            $projects = \App\Project::all();                
        } elseif ($request->user()->hasRole(UserRole::PROJECT_COORDINATOR)) {
            return redirect()->route('project_coordinator.projects.index');
        } elseif ($request->user()->hasRole(UserRole::SITE_MANAGER)) {
            return redirect()->route('site_manager.projects.index');
            //$projects = $request->user()->manageProjects;
        } elseif ($request->user()->hasRole([UserRole::SALE_TEAM_LEADER, UserRole::AGENT])) {
            return redirect()->route('sale.projects.index');
        } elseif ($request->user()->hasRole([UserRole::SITE_ENGINEER])) {
            return redirect()->route('site_engineer.home');
        } elseif ($request->user()->hasRole([UserRole::HANDOVER_OFFICER])) {
            return redirect()->route('handover_officer.projects.index');
        }

        
        return view('home', compact('projects'));
    }
}
