<?php

namespace App\Http\Controllers\SaleAgent;

use App\UnitType;
use App\Helpers\UnitStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitTypeController extends Controller
{
    public function show(Request $request, $id)
    {
    	$unit_type = UnitType::findOrFail($id)->load(['media']);
    	$unit_status = UnitStatus::getUnitStatuses();

    	$units = $unit_type->units()
		->when( $term = $request->term, function ($query, $term) {
		 	return $query->where('code', 'LIKE', "%$term%");
		})
		->when( $status = $request->status, function ($query, $status) { 
		 	return $query->whereHas('action', function ($sub_query) use ($status) {
		 		return $sub_query->where('action', $status);
		 	});
		})
		->paginate();

    	return view('sale_agent.unit_type.single', compact('unit_type', 'units', 'unit_status'));
    }
}
