<?php

namespace App\Http\Controllers\Api;

use App\UnitHoldRequest;
use App\UnitDepositRequest;
use App\UnitContractRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class UnitActivityController extends Controller
{
    public function getStatistic(Request $request)
    {    	
    	$from_date = $request->from ? Carbon::createFromFormat('Y-m-d', $request->from)->startOfDay() : Carbon::now()->startOfDay();

    	$to_date = $request->to ? Carbon::createFromFormat('Y-m-d', $request->to)->endOfDay() : Carbon::now()->endOfDay();
    	$group_by = $request->group_by ?? 'DAY';    	

    	$unit_hold_requests = UnitHoldRequest::ofCountStatistic($from_date, $to_date, $group_by)->get()->toArray();
    	$unit_deposit_requests = UnitDepositRequest::ofCountStatistic($from_date, $to_date, $group_by)->get()->toArray();
    	$unit_contract_requests = UnitContractRequest::ofCountStatistic($from_date, $to_date, $group_by)->get()->toArray();
    	
    	$result = $this->buildDateRangeGap($from_date, $to_date, $group_by);    
    	
    	$data = [
    		'UnitHoldRequest' => array_replace($result, $unit_hold_requests),
    		'UnitDepositRequest' => array_replace($result, $unit_deposit_requests),
    		'UnitContractRequest' => array_replace($result, $unit_contract_requests)
    	];

    	return $this->sendSuccessResponse('Success', 200, $data);
    }

    private function buildDateRangeGap($from, $to, $group_by = 'DAY') 
    {
    	switch ($group_by) {
    		case 'MONTH': 
    			return $this->buildMonthGap($from, $to);    			
    		case 'YEAR':    		
    			return $this->buildYearGap($from, $to);    			 		
    		default:
    			return $this->buildDayGap($from, $to);    			
    	}
    }

    private function buildYearGap($from, $to) 
    {
    	$result = [];
    	while( $to->greaterThanOrEqualTo($from) ) {   
    		$result[] = [ 'date' => $from->format('Y'), 'count' => 0 ];
    		$from->addYear();
    	}  
    	return $result; 
    }

    private function buildMonthGap($from, $to) 
    {
		$result = [];
    	while( $to->greaterThanOrEqualTo($from) ) {   
    		$result[] = [ 'date' => $from->format('Y-m'), 'count' => 0 ];
    		$from->addMonth();
    	}  
    	return $result; 
    }

    private function buildDayGap($from, $to) 
    {
    	$result = [];
    	while( $to->greaterThanOrEqualTo($from) ) {   
    		$result[] = [ 'date' => $from->format('Y-m-d'), 'count' => 0 ];
    		$from->addDay();
    	}  
    	return $result; 
    }
}
