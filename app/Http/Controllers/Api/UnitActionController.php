<?php

namespace App\Http\Controllers\Api;

use App\Unit;
use App\UnitAction;
use App\Helpers\UserRole;
use App\Http\Resources\UnitActionCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitActionController extends Controller
{
    public function get(Request $request)
    {

        $auth_user = $request->user();
        $set_status_success = false;

        if ( ($auth_user->hasRole([UserRole::AGENT]))) {
            return $this->sendErrorJsonResponse( __("You don't have permission to process your request") , 403);
        }
        
        $unit_actions = UnitAction::query();
        
        if ( $request->input('term') ) {
            $term = $request->input('term');
            $unit_actions = $unit_actions->whereHas('unit', function ($query) use ($term)  {
                $query->where('code', 'LIKE', '%'.$term.'%');
            });  
        }

        if ( $request->input('unit_type') ) {
            $unit_actions = $unit_actions->byUnitType($request->input('unit_type'));
        }

        if ( $request->input('action') ) {          
            $unit_actions = $unit_actions->whereIn('action',$request->input('action'));
            $unit_actions = $unit_actions->whereIn('status_action', ['PENDING', '']);
        }
    
        if ( $request->input('from') AND $request->input('to') ) {
            $from =  $request->input('from');
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('to'). " 23:59:59");
            $unit_actions = $unit_actions->whereBetween('created_at', [$from, $to]);
        } else {
            $unit_actions = $unit_actions->recent();
        }

        if ( $request->input("embed") ) {           
            $relationships = explode(',', trim($request->input('embed')) );
            $unit_actions = $unit_actions->with($relationships);
        }

        return new UnitActionCollection($unit_actions->paginate());
    }

    public function getAllByUnitId(Request $request, $id) 
    {
        $unit_actions = UnitAction::query();
        $unit_actions = UnitAction::where('unit_id', $id);

        if ( $request->input("embed") ) {           
            $relationships = explode(',', trim($request->input('embed')) );
            $unit_actions = $unit_actions->with($relationships);
        }

        return new UnitActionCollection($unit_actions->paginate( $request->per_page ?? (New UnitAction)->getPerPage() ));
    }
}
