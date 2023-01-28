<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Contract;
use App\UnitAction;
use App\UnitContractRequest;
use App\UnitDepositRequest;
use App\Helpers\ContractStatus;
use App\Helpers\UnitDepositStatus;
use App\Helpers\UnitContractStatus;
use App\Notifications\UnitContractRequestVoided;
use App\Notifications\UnitDepositRequestVoided;
use App\Http\Controllers\Controller;
use App\Http\Requests\VoidContractRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoidContractController extends Controller
{
    public function processVoidRequest(VoidContractRequest $request, $id)
    {
    	$validated_data = $request->validated();

    	$contract = Contract::findOrFail($id);
		if ( !$contract->isVoidable() ) {
			return response()->json([
				'status' => __('Error'), 
				'message' => __('The contract is not in the status which allow you to void.')
			], 422);
		}

		// assign cancellation data from request
		$contract->setAction(ContractStatus::VOIDED, $validated_data['action_reason']);

		// check if the contract is related with unit_contract_request object
		$unit_contract_request = null;
		$unit_deposit_request = null;
		if ( $contract->unit_contract_request_id ) {
			$unit_contract_request = $contract->unitContractRequest;
			$unit_deposit_request = $unit_contract_request->unitDepositRequest;

			$unit_contract_request->setAction(UnitContractStatus::VOIDED, $validated_data['action_reason']);
			$unit_deposit_request->setAction(UnitDepositStatus::VOIDED, $validated_data['action_reason']);
		}

		try {
			DB::beginTransaction();
			$contract->save();
			if ( !is_null($unit_contract_request ) ) {
				$unit_contract_request->save();
				$unit_deposit_request->save();				
			}

			// add Action history to Unit Object
            UnitAction::create([
                'user_id' => $request->user()->id,
                'unit_id' => $contract->unit_id,
                'action' => ContractStatus::CONTRACT,
                'status_action' => ContractStatus::VOIDED,              
                'actionable_type' => $contract->getMorphClass(),
                'actionable_id' => $contract->id
            ]);
            UnitAction::makeUnitAvailableBySystem($contract->unit_id);

            if ( !is_null($unit_contract_request) ) {
            	// notification
				$agent = User::where('id', $unit_contract_request->user_id)->first();
				$agent->notify( new UnitDepositRequestVoided(
	                $unit_deposit_request, 
	                $request->user()->roles()->first()->name
	            ));
	            $agent->notify( new UnitContractRequestVoided(
	            	$unit_contract_request,
	            	$request->user()->roles()->first()->name
	            ));
            }

			DB::commit();
			return response()->json([
                'status' => __('success'), 
                'message' => __('Contract has been voided successfully.')
            ], 200);
		} catch (\Exception $e) {
			DB::rollback();		
			return response()->json([
                'status' => __('error'), 
                'message' => $e->getMessage()
            ], 500);
		}
    }
}
