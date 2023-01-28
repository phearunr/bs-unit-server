<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use Carbon\Carbon;

class ProjectStatisticController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::with([ 'unitTypes' => function ($query) { 
            $query->withCount([
                'units',
                'units as available_unit_type_count' => function ($query) {
                    $query->whereHas('action', function ($sub_query) {
                        $sub_query->where('action', 'available');
                    });
                },
                'units as unavailable_unit_type_count' => function ($query) {
                    $query->whereHas('action', function ($sub_query) {
                        $sub_query->where('action', 'unavailable');
                    });
                },
                'units as hold_unit_type_count' => function ($query) {
                    $query->whereHas('action', function ($sub_query) {
                        $sub_query->where('action', 'hold');
                    });
                },
                'units as deposit_unit_type_count' => function ($query) {
                    $query->whereHas('action', function ($sub_query) {
                        $sub_query->where('action', 'deposit');
                    });
                },
                'units as contract_unit_type_count' => function ($query) {
                    $query->whereHas('action', function ($sub_query) {
                        $sub_query->where('action', 'contract');
                    });
                }
            ]); 
        } ])
        ->get();    
        
        $data = [];
        foreach( $projects AS $project ) {
            $item = [];
            $item['project'] = $project;
            foreach($project->unitTypes AS $unitType) {
                $item['units'][$unitType->id] = [
                    'AVAILABLE' => $unitType->available_unit_type_count,
                    'UNAVAILABLE' => $unitType->unavailable_unit_type_count,
                    'HOLD' => $unitType->hold_unit_type_count,
                    'DEPOSIT' => $unitType->deposit_unit_type_count,
                    'CONTRACT' => $unitType->contract_unit_type_count
                ];
                $unitType->makeHidden([
                    'available_unit_type_count', 
                    'unavailable_unit_type_count',
                    'hold_unit_type_count',
                    'deposit_unit_type_count',
                    'contract_unit_type_count'
                ]);
            }
            $data[]= $item;
        }     
        return response()->json([ 
            'data' => $data,
            'code' => 200,
            'message' => __('Success')
        ]);
    }
    public function show($id)
    {
        $project = Project::with([ 'unitTypes' => function ($query) { 
            $query->withCount([
                'units',
                'units as available_unit_type_count' => function ($query) {
                    $query->whereHas('action', function ($sub_query) {
                        $sub_query->where('action', 'available');
                    });
                },
                'units as unavailable_unit_type_count' => function ($query) {
                    $query->whereHas('action', function ($sub_query) {
                        $sub_query->where('action', 'unavailable');
                    });
                },
                'units as hold_unit_type_count' => function ($query) {
                    $query->whereHas('action', function ($sub_query) {
                        $sub_query->where('action', 'hold');
                    });
                },
                'units as deposit_unit_type_count' => function ($query) {
                    $query->whereHas('action', function ($sub_query) {
                        $sub_query->where('action', 'deposit');
                    });
                },
                'units as contract_unit_type_count' => function ($query) {
                    $query->whereHas('action', function ($sub_query) {
                        $sub_query->where('action', 'contract');
                    });
                }
            ]); 
        } ])       
        ->where('id', $id)
        ->firstOrFail();

        $data['project'] = $project;
        
        $units_status_count = array();
        foreach($project->unitTypes as $key => $unit_type) {
            $units_status_count['AVAILABLE'] = $unit_type->available_unit_type_count;
            $units_status_count['UNAVAILABLE'] = $unit_type->unavailable_unit_type_count;
            $units_status_count['HOLD'] = $unit_type->hold_unit_type_count;
            $units_status_count['DEPOSIT'] = $unit_type->deposit_unit_type_count;
            $units_status_count['CONTRACT'] = $unit_type->contract_unit_type_count;
            $unit_type->makeHidden([
                'available_unit_type_count', 
                'unavailable_unit_type_count',
                'hold_unit_type_count',
                'deposit_unit_type_count',
                'contract_unit_type_count'
            ]);
            $data['units'][$unit_type->id] = $units_status_count;
        }
        
        $unit_id_list = $this->getUnitInProject($id);
        
        $data['activities']['HOLD'] = \App\UnitHoldRequest::whereIn('unit_id', $unit_id_list)->count();
        $data['activities']['DEPOSIT'] = \App\UnitDepositRequest::whereIn('unit_id', $unit_id_list)->count();
        $data['activities']['CONTRACT'] = \App\UnitContractRequest::whereIn('unit_id', $unit_id_list)->count();
    
        return response()->json([ 
            'data' => $data,
            'code' => 200,
            'message' => __('Success')
        ]);
    }
    /**
     * Filter Project Statistic.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request, $id)
    {
        $validator = Validator::make( $request->all(), [
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'group_by' => 'required|in:day,week'
        ]);

        if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

        $from = Carbon::parse($request->from_date)->startOfDay();
        $to = Carbon::parse($request->to_date)->endOfDay();

        $num_day = $to->diffInDays($from) + 1;  
        $num_item = 0;    
        if ( $request->group_by == 'week' ) {
            $num_week =  floor($num_day / 7);     
            if ( ($num_day % 7) > 0 ) {
                $num_week += 1;
            }
            $num_item = $num_week;
        } else {
            $num_item = $num_day;
        }

        $unit_id_list =  $this->getUnitInProject($id);

        $data = [];
        for ($i = 0; $i < $num_item; $i++) { 
            if ( $request->group_by == 'week' ) {
                $next_day = $from->copy()->addDays(6)->endOfDay();
            } else {
                $next_day = $from->copy()->endOfDay();
            } 
            $next_day = min($next_day, $to);
            $item['from_date'] = $from->toDateTimeString();
            $item['to_date'] = $next_day->toDateTimeString();
            $item['activities'] = [
                'HOLD' => \App\UnitHoldRequest::whereBetween('created_at', [ $from, $next_day])->whereIn('unit_id',  $unit_id_list)->count(),
                'DEPOSIT' => \App\UnitDepositRequest::whereBetween('created_at', [ $from, $next_day])->whereIn('unit_id',  $unit_id_list)->count(),
                'CONTRACT' => \App\UnitContractRequest::whereBetween('created_at', [ $from, $next_day])->whereIn('unit_id',  $unit_id_list)->count()
            ];
            $from = $next_day->addSecond();
            $data[] = $item;         
        }

        return response()->json([ 
            'data' => $data,
            'code' => 200,
            'message' => __('Success')
        ]); 
    }

    private function getUnitInProject($project_id) 
    {
        return Project::with(['units' => function ($query) {  
            return $query->without(['unitType', 'action'])->select(['units.id']);
        }])
        ->where('id', $project_id)
        ->firstOrFail()->units->pluck('id');   
    }
}
