<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Project;
use App\Contract;
use App\Unit;
use App\UnitAction;
use App\UnitContractRequest;
use App\ContractRequest;
use App\Helpers\UserRole;
use App\Helpers\UnitContractStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\UnitContractRequestNotificationController;
use Spatie\Permission\Models\Role;

class CreateContractController extends Controller
{  
   protected $validationRules = [
         'unit_contract_request_id' => 'nullable|exists:unit_contract_requests,id',
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
         'agent_remark' => 'nullable|string|max:500',       
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
         "first_payment_amount" => "required_with:first_payment_percentage|numeric|min:0",
         "start_payment_number" => "required|integer|min:0",
         "annual_management_fee" => "required|numeric|min:0",
         "contract_transfer_fee" => "required|numeric|min:0",
         "management_fee_per_square" => "required|numeric|min:0",
         "deadline" => "required|integer|min:0",
         "extended_deadline" => "required|integer|min:0",         
         "title_clause_kh" => "nullable|string",
         "management_service_kh" => "nullable|string",
         "equipment_text" => "nullable|string",
         'attachments' => 'required|array|between:1,9',
         'attachments.*' => 'required|image'
   ];

   public function showCreateForm(Request $request, $unit_contract_id = null) 
   { 
      // $contract_request = new ContractRequest();   
      $agents = User::role([UserRole::AGENT,UserRole::SALE_TEAM_LEADER])->get(['id','name','phone_number','gender']);
      return view('admin.contract.new', compact("agents","payment_option"));
   }

   public function store(Request $request) 
   {  
      $validatedData = $request->validate($this->getValidationRules()); 
      $contract = New Contract();
      $validatedData['user_id'] = Auth::id();
      // convert Date from user input to Database Friendly format
      $validatedData = $this->covertToStandardDateFormat($validatedData, $contract->getDates());
      $unit = Unit::findOrFail($request->unit_id);
      // check if unit availability
      if ( !$request->unit_contract_request_id AND $unit->isAvailable() == false  ) {
         return back()->withInput()->withErrors([ 'contract' => __("The unit is not available for making contract.")]);
      }

      if ( $request->unit_contract_request_id ) {
         $unit_contract_request = UnitContractRequest::find($request->unit_contract_request_id);
         if ( $unit_contract_request->getOriginal('contract_id') != null ) {
            return redirect()->route('admin.contracts.index')->withErrors(['contract' => __("The contract has already been created for this request.")]);
         }
      }

      try {
         DB::beginTransaction();
         $contract->fill($validatedData);
         $contract->save();
         foreach($request->attachments as $key => $file) {
            $path = $file->store("contract","public");
            $contract->attachments()->create([
               'path' => $path,
               'type' => $key
            ]);
         }
         // Set Status OPEN to unit_contract_reqeust
         if ( $request->unit_contract_request_id ) {
            $this->setUnitContractRequestStatus($unit_contract_request, UnitContractStatus::OPEN, $validatedData['user_id'],$contract->id);
            // Send Notification to Owner of unit_contract_request object;
            $owner = User::where('id', $unit_contract_request->user_id)->first();
            UnitContractRequestNotificationController::notifyRequestOpen($owner, $unit_contract_request);
         } else {
            $this->createUnitAction($contract, UnitContractStatus::OPEN, $validatedData['user_id']);
         }

         DB::commit();
         return redirect()->route('admin.contracts.edit', ['id' => $contract->id])
                          ->with('status',"Contract has been successfully created.");
      } catch (\Exception $e) {
         DB::rollback();        
         return back()->withInput()->withErrors([ 'contract' => $e->getMessage()]);
      } finally {
         if ( isset( $contract ) ){
            // $this->sendCreatedNotification($contract_request);
         }
      }
   }

   private function setUnitContractRequestStatus(UnitContractRequest $unit_contract_request, $status, $action_user_id, $contract_id = null)
   {
      try {        
         $unit_contract_request->status = $status;
         $unit_contract_request->contract_id = $contract_id;
         $unit_contract_request->actioned_user_id = $action_user_id;
         $unit_contract_request->actioned_at = now();
         $unit_contract_request->save();
         $this->createUnitAction($unit_contract_request, $status, $action_user_id);
      } catch (\Exception $e) {
         throw new \Exception($e->getMessgae(), $e->getCode());
      }
   }

   private function createUnitAction($model, $status, $user_id)
   {
      return  UnitAction::create([
         'user_id'       =>  $user_id,
         'unit_id'       => $model->unit_id,
         'action'        => $status == 'AVAILABLE' ? 'AVAILABLE' : 'CONTRACT',
         'status_action' => $status == 'AVAILABLE' ? '' :  $status,
         'actionable_type' => $model->getMorphClass(),
         'actionable_id' => $model->id
      ]);
   }

   private function getValidationRules()
   {
      return $this->validationRules;
   }
}