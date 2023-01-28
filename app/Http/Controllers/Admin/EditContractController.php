<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Contract;
use App\ContractRequest;
use App\ContractAttachment;
use App\Project;
use App\PaymentOption;
use App\Helpers\ContractStatus;
use App\Helpers\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class EditContractController extends Controller
{
   public function showEditForm($id) 
   {	
      $projects = Project::with(['unitTypes'])->get();     
      $contract = Contract::findOrFail($id);   
      $payment_options = PaymentOption::where("unit_type_id", $contract->unit->unit_type_id)->get();
      $unit = $contract->unit;
      $sale_representative = $contract->saleRepresentative;    
      $agents = User::role([UserRole::AGENT,UserRole::SALE_TEAM_LEADER])->get(['id','name','phone_number']);
      $agent = User::where('id',$contract->agent_id)->first(['id','name','phone_number','gender']);  
      $attachments = $contract->getAttachmentsArrayWithTypeKey();
      return view('admin.contract.edit', compact(
         'contract',
         'projects',
         'agents',
         'agent',
         'attachments',
         'payment_options',
         'unit',
         'sale_representative'
      ));
   }

	public function update(Request $request, $id) 
   {    
      $user_id = Auth::id();
      $contract = Contract::findOrFail($id);
      // check if owner
      if ( !$contract->isOwner($user_id) ) {
         return back()->withInput()->withErrors([ 'contract' => __("Can not update the record. You are not owner of the record.")]);
      }

      if ( !$contract->isEditable() ) {
         return back()->withInput()->withErrors([ 'contract' => __("Can not update the record. The contract is not in the status which allow you to update.")]);
      }

      $validatedData = $request->validate([
         'customer1_name' => 'required|string|min:4|max:255',
         'customer1_gender' => 'required|integer|min:1|max:2',
         'customer1_birthdate' => 'required|date',
         'customer1_nationality' => 'required|string|max:191',
         'customer1_nid' => 'required|string|max:100',
         'customer1_nid_issued_date' => 'required|date',
         'customer2_name' => 'nullable|string|min:4|max:255',
         'customer2_gender' => 'nullable|integer|min:0|max:2',
         'customer2_birthdate' => 'nullable|date',
         'customer2_nationality' => 'required|string|max:191',
         'customer2_nid' => 'nullable|string|max:100',
         'customer2_nid_issued_date' => 'nullable|date',
         'customer_phone_number' => 'required|regex:(^0\d{8,9}$)',
         'customer_phone_number2' => 'nullable|regex:(^0\d{8,9}$)',
         'customer_address_line1' => 'required|string|max:500',
         'customer_address_line2' => 'required|string|max:500',
         // 'customer_house_no' => 'required|string|max:100',
         // 'customer_street' => 'required|string|max:100',
         // 'customer_phum' => 'required|string|max:200',
         // 'customer_commune' => 'required|string|max:200',
         // 'customer_district' => 'required|string|max:200',
         // 'customer_city' => 'required|string|max:200',
         'sale_representative_id' => 'required|exists:sale_representatives,id',
         'agent_id' => 'nullable|exists:users,id',
         'unit_sold_at' => 'required|date',
         'signed_at' => 'required|date',
         'unit_id' => 'required|integer|exists:units,id',
         'service_fee' => 'nullable|numeric|min:0',
         'unit_sale_price' => 'required|numeric|min:0|max:999999999.99',
         'discount_promotion'    => 'nullable|numeric|min:0|max:999999999.99',
         'other_discount_allowed' => 'nullable|numeric|min:0|max:999999999.99',
         'deposited_amount' => 'required|numeric|min:0|max:999999999.99',
         'deposited_at' => 'required|date',
         'start_payment_date' => 'required|date|after_or_equal:deposited_date',    
         'payment_option_id' => "nullable|exists:payment_options,id",
         'loan_duration' => "required|integer|min:1",
         "interest" => "required|numeric|min:0",
         "special_discount" => "required|numeric|min:0",
         "is_first_payment" => "required|boolean",
         "first_payment_duration" => "required|integer|min:0",
         "first_payment_percentage" => "nullable|integer|min:0",
         "first_payment_amount" => "nullable|numeric|min:0",
         "loan_result_rounding" => "nullable|boolean",
         "start_payment_number" => "nullable|integer|min:0",
         "annual_management_fee" => "required|numeric|min:0",
         "contract_transfer_fee" => "required|numeric|min:0",
         "management_fee_per_square" => "required|numeric|min:0",
         "deadline" => "required|integer|min:0",
         "extended_deadline" => "required|integer|min:0",
         "title_clause_kh" => "nullable|string",
         "management_service_kh" => "nullable|string", 
         "equipment_text" => "nullable|string",
         'attachments' => 'nullable|array|between:1,9',
         'attachments.*' => 'nullable|image'
      ]);

      $validatedData['user_id'] = Auth::id();
      // convert Date from user input to Database Friendly format
      $validatedData  = $this->covertToStandardDateFormat($validatedData, $contract->getDates());
		try {
         if ( $request->attachments ) {
            foreach($request->attachments as $key => $file) {
               $attachment = ContractAttachment::where('contract_id', $contract->id)->where('type',$key)->first();
               if ( $attachment ) {
                  $attachment->delete(); 
               }               
               $path = $file->store("contract","public");
               $contract->attachments()->create([
                  'path' => $path,
                  'type' => $key
               ]);
            }
         }

         $contract = $contract->fill($validatedData);   
         $contract->save();         
			// return redirect()->route('admin.contracts.edit',[ 'id' => $contract->id ])
         //                        ->with("status", __("Contract has been updated successfully."));        
         // return redirect()->route('admin.contracts.print', [ 'id' => $contract->id]);
         return redirect()->route('admin.contracts.print', [ 'id' => $contract->id, 'version' => 'v2']);
		} catch (\Exception $e) {   			
			return back()->withInput()->withErrors([ 'contract' => $e->getMessage()]);
		} finally {
			//if edit successful, send notification
			if ( isset( $contract ) ){
			   // $this->sendCreatedNotification($contract_request);
			}
		}
	}
}
