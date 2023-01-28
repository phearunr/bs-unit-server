<?php

namespace App\Imports;

use App\Unit;
use App\UnitAction;
use App\Helpers\UnitStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class UnitBulkModifyStatus
	implements ToCollection, WithHeadingRow, WithBatchInserts
{
	protected $action;
	protected $action_status;

	public function __construct($action = null, $action_status = null) 
	{
		$unit_status_array = UnitStatus::getUnitStatuses();

		switch ($action) {			
			case 'CONTRACT':		
				// For next update
				// $action_status_array = \App\Helpers\UnitContractStatus::toArray();
				// if ( ! in_array($action_status, $action_status_array) ) {
				// 	throw new \InvalidArgumentException('The Action Status you provided is incorrect', 0);
				// }

				// Allow Only OPEN action_status only
				if ( $action_status != 'OPEN' ) {

				}
				break;		
			default:
				throw new \InvalidArgumentException('The Action you provided is incorrect', 0);
				break;
		}

		$this->action = $action;
		$this->action_status = $action_status;
	}

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection) {
        $auth_user_id = Auth::id();

        foreach ($collection as $row) {
        	if ( isset($row['unit_id']) AND $row['unit_id'] != "" ) {
        		try {
        			$unit = Unit::select('id','unit_action_id')->where('id', $row['unit_id'])->first();   
        						
        			if ( $unit->action->action == UnitStatus::UNAVAILABLE 
        				OR  $unit->action->action == UnitStatus::AVAILABLE) {

        				$unit_action =  UnitAction::create([
			                'user_id' => $auth_user_id,
			                'unit_id' => $row['unit_id'],
			                'action' => $this->action,
			                'status_action' => $this->action_status,
			                'description' => 'Bulk Action from import',
			                'meta_data' => "",
			                'actionable_type' => "",
			                'actionable_id' => 0
			            ]);
        			}
        			
        		} catch (\Exception $e) {
        			Log::error('App\\Imports\\UnitBulkChangeStatus - '.$e->getMessage());
        		}
        	}
        }
    }

    public function batchSize(): int
    {
        return 50;
    }
}
