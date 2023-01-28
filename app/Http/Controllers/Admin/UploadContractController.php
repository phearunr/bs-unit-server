<?php

namespace App\Http\Controllers\Admin;

use App\Contract;
use App\UnitContractRequest;
use App\UnitAction;
use App\Helpers\UnitContractStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UploadContractController extends Controller
{
	public function showContractUploadForm(Request $request, $id)
	{	
		$contract = Contract::findOrFail($id);
		return view("admin.contract.upload", compact("contract"));
	}

	public function uploadContractPDF(Request $request, $id)
	{
		$contract = Contract::findOrFail($id);

		if ( $contract->user_id != Auth::id() ) {
			return back()->withErrors([ 'contract' => __("Can not upload! you are not the creator of the contract.")]);
		}

		$request->validate([
			'signed_contract_file_url' => "required|file|mimes:pdf"
		]);

		try {
			DB::beginTransaction();
			$file_extension = $request->file('signed_contract_file_url')->extension();
			$path = $request->file('signed_contract_file_url')->storeAs(
			    'contract_signed', 
			    $contract->unit->code.'_'.$contract->customer1_name.'_'.$contract->id.".".$file_extension,
			    'public'
			);
			$contract->signed_contract_file_url = $path;
			$contract->save();

			// check if there is unit_contract_request_id
			if ( !is_null($contract->unit_contract_request_id) ) {
				$unit_contract_request = UnitContractRequest::findOrFail($contract->unit_contract_request_id);
				$unit_contract_request->status = UnitContractStatus::RELEASED;				         		
         		$unit_contract_request->actioned_user_id = Auth::id();
         		$unit_contract_request->actioned_at = now();
         		$unit_contract_request->save();
         		// Send notification to owner of unit_contract_request

			}
			// create unit_action object		
			UnitAction::create([
				'user_id'       =>  Auth::id(),
				'unit_id'       => $contract->unit_id,
				'action'        => 'CONTRACT',
				'status_action' => UnitContractStatus::RELEASED,
				'actionable_type' => $unit_contract_request->getMorphClass(),
				'actionable_id' => $unit_contract_request->id
  			]);

			DB::commit();
         	return redirect()->route('admin.contracts.index')
                          ->with('status',"Contract has been successfully uploaded.");
		} catch (\Exception $e) {
			DB::rollback();
			return back()->withInput()->withErrors([ 'contract' => $e->getMessage()]);	
		}
		
	}
}
