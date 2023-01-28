<?php

namespace App\Http\Controllers\ProjectCoordinator;

use App\Company;
use App\Project;
use App\Helpers\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index(Request $request){
        $projects = Project::query();
        $companies = Company::all();
                
        $proejcts = $projects->when($company = $request->company, function ($query, $company) {
            return $query->where('company_id', $company);
        });

        $projects = $projects->search($request->query('term'))
                           ->ofStatus($request->query('status') ?? 'all');

        $projects = $projects->paginate($request->query('per_page') ?? 20);
        
        return view ('project_coordinator.project.index', compact('projects', 'companies'));
    }

    public function show($id)
    {
        $project = Project::withCount([
            'units',  
            'units AS progress_average' => function ($query) {
                $query->select(DB::raw('AVG(construction_overall_progress) as progress_average'));
            },         
            'units as available_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'available');
                });
            },
            'units as unavailable_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'unavailable');
                });
            },
            'units as hold_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'hold');
                });
            },
            'units as deposit_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'deposit');
                });
            },
            'units as contract_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'contract');
                });
            },
            'units as handovered_unit_count' => function ($query) {
                $query->whereHas('action', function ($sub_query) {
                    $sub_query->where('action', 'handovered');
                });
            }
        ])
        ->with([ 
            'unitTypes' => function ($query) { 
                $query->withCount('units'); 
            },
            'unitTypes.activeDiscountPromotions',
            'zones' => function ( $query ) {
                $query->withCount('units');
                $query->withCount('managedUsers');
                $query->withCount([ 'units AS progress_average' => function ($query) {
                    $query->select(DB::raw('AVG(construction_overall_progress) as progress_average'));
                }]);
            },
        ])
        ->findOrFail($id);

        return view('project_coordinator.project.single', compact('project'));
    }

    public function showMasterPlan($id)
    {
        $project = Project::findOrFail($id);        
        return view('project_coordinator.project.master_plan', compact('project'));
    }

    public function getUnitTypes(Request $request, $id) 
    {
        $unit_types = Project::findOrFail($id)->unitTypes();
        if ( $request->fields ) {
            $fields = explode(',', $request->fields );         
            $unit_types = $unit_types->select( (is_array($fields) ? $fields : '*' ) );           
        }

        if ( $request->wantsJson() ) {
            return $unit_types->get();
        }
    }

    public function getUnitHandovers(Request $request, $id) 
    {
        $batch_id = $request->query('batch_id') ?? null;
        $project = Project::where('id', $id)->firstOrFail();

        $project = Project::findOrFail($id)->load([
            'units' => function ($query) {        
                $query->without(['action.createdBy','unitType','unitType.project'])
                ->has('unitHandover')
                ->with('unitHandover')
                ->select(['units.id', 'unit_type_id', 'unit_action_id', 'code', 'price']);
            },
            'units.action' => function ($query) {
                $query->select(['id', 'action']);
            }
        ]);

        if ( $request->wantsJson() ) {            
            return $project->units;
        }
        
        return abort(404);
    }

}
