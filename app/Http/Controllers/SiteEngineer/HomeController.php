<?php

namespace App\Http\Controllers\SiteEngineer;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
		$zones = request()->user()->manageZones;
        $arr_zone_id = $zones->pluck('id')->toArray();
        $arr_project_id = array_values(array_unique($zones->pluck('project_id')->toArray()));
        
        $projects = \App\Project::whereIn('id', $arr_project_id)->with(['zones' => function($query) use ($arr_zone_id) {
            $query->whereIn('id', $arr_zone_id);
            $query->withCount('units');
            $query->withCount('managedUsers');
            $query->withCount([ 'units AS progress_average' => function ($query) {
                    $query->select(DB::raw('AVG(construction_overall_progress) as progress_average'));
            }]);
            return $query;
        }])->get();
        return view('site_engineer.home', compact('projects'));
    }
}
