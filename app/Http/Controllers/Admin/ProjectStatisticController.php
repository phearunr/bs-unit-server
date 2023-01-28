<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
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
        $response['project'] = Project::withCount([
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
        ])
        ->with([ 'unitTypes' => function ($query) { 
        	$query->withCount('units'); 
        } ])
        ->get();
        $units_by_status = array();
        foreach ($response['project'] as $key => $value) {
            $units_by_unit_type = array();
            foreach ($value->unitTypes as $row) {
                $units_by_unit_type[$row->id] = $row->units_count;
            }
            $data[$key]['project'] = $value;
            $data[$key]['units_by_unit_type'] = $units_by_unit_type;
            $units_by_status["AVAILABLE"] = $value->available_unit_count;
            $units_by_status["UNAVAILABLE"] = $value->unavailable_unit_count;
            $units_by_status["HOLD"] = $value->hold_unit_count;
            $units_by_status["DEPOSIT"] = $value->deposit_unit_count;
            $units_by_status["CONTRACT"] = $value->contract_unit_count;
            $data[$key]['units_by_status'] = $units_by_status;
        }
        return response()->json([ 
            'data' => $data,
            'code' => 200,
            'message' => __('Success')
        ]);
    }
    public function show($id)
    {

        $project = Project::withCount([
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
        ])
        ->with([ 'unitTypes' => function ($query) { 
            $query->withCount('units'); 
        } ])       
        ->where('id', $id)
        ->firstOrFail();       

        $data['project'] = $project->makeHidden([
            'units_count',
            'available_unit_count', 
            'unavailable_unit_count',
            'hold_unit_count',
            'deposit_unit_count',
            'contract_unit_count'
        ]);

        foreach($project->unitTypes as $unit_type) {
            $data['units_by_unit_type'][$unit_type->id] = $unit_type->units_count;
        }
        $data['units_by_status']['AVAILABLE'] = $project->available_unit_count ;
        $data['units_by_status']['UNAVAILABLE'] = $project->unavailable_unit_count;
        $data['units_by_status']['HOLD'] = $project->hold_unit_count;
        $data['units_by_status']['DEPOSIT'] = $project->deposit_unit_count;
        $data['units_by_status']['CONTRACT'] = $project->contract_unit_count;
    
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
            $num_week = $num_day / 7;     
            if ( ($num_day % 7) > 0 ) {
                $num_week += 1;
            }
            $num_item = $num_week;
        } else {
            $num_item = $num_day;
        }

        $units = Project::findOrFail($id)
        ->units()
        ->without(['unitType'])
        ->with(['action' => function ($query) {  
            return $query->select(['id', 'action', 'created_at']);
        }])
        ->whereHas('action', function ($query) use ($from, $to) {      
            $query->whereBetween('created_at', [$from, $to]);        
        })
        ->select(['units.id','code', 'unit_type_id', 'unit_action_id'])
        ->get();

        $data = [];
        for ($i = 0; $i < $num_item; $i++) { 
            if ( $request->group_by == 'week' ) {
                $next_day = $from->copy()->addDays(6)->endOfDay();
            } else {
                $next_day = $from->copy()->endOfDay();
            }
            // $count = 0;
            $count = $units->whereBetween('action.created_at', [$from, $next_day])
            ->groupBy(function ($val) {
                return $val->availability_status;
            })
            ->map(function ($item, $key) {
                return collect($item)->count();
            })
            ->union([
                'AVAILABLE' => 0,
                'UNAVAILABLE' => 0,
                'HOLD' => 0,
                'DEPOSIT' => 0,
                'CONTRACT' => 0,
            ]);
            $item['from_date'] = $from->toDateTimeString();
            $item['to_date'] = $next_day->toDateTimeString();
            $item['units_by_status'] = $count;
            $from = $next_day->addSecond();
            $data[] = $item;
        }

        return response()->json([ 
            'data' => $data,
            'code' => 200,
            'message' => __('Success')
        ]);
    }
}
