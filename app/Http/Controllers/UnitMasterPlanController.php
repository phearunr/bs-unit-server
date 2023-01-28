<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitMasterPlanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {           
        // reduce response size and time for Master Plan
        $project = Project::findOrFail($request->project_id)->load([
            'units' => function ($query) {               
                $query->without(['action.createdBy','unitType','unitType.project'])
                ->with('unitHandover')
                ->select(['units.id', 'unit_type_id', 'unit_action_id', 'code', 'price']);
            },
            'units.action' => function ($query) {
                $query->select(['id', 'action', 'status_action']);
            }
        ]);

        if ( $request->wantsJson() ) {
            return $project->units;
        }
    }
}
