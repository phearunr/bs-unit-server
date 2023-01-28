<?php

namespace App\Http\Controllers\ProjectCoordinator;

use App\Project;
use App\UnitType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProjectUnitTypeController extends Controller
{
    public function show(Request $request, $project_id, $unit_type_id)
    {   
        // check whether the requested unit_type_id is in project or not
        if ( $this->project->unitTypes()->where('id', $unit_type_id)->count() == 0 ) {
            abort(404);
        }

        $unit_type = UnitType::withCount([
            'units',
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
            }
        ])->with(['project', 'media'])->findOrFail($unit_type_id);
 
        return view('project_coordinator.project.unit_type.single', compact('unit_type'));
    }


}
