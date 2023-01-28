<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\User;
use App\UnitAction;
use App\UnitDepositRequest;
use App\UnitContractRequest;
use App\UnitContractRequestAttachment;
use App\Helpers\UnitDepositStatus;
use App\Helpers\UnitContractStatus;
use App\Helpers\UserRole;
use App\Http\Resources\UnitContractRequest as UnitContractRequestResource;
use App\Http\Resources\UnitContractRequestCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UnitContractRequestController extends Controller
{	
	protected $validationRules =  [ 
		'unit_deposit_request_id' => "required|exists:unit_deposit_requests,id",
        'remark' => 'nullable|string|max:500',
        'signed_at' => 'required|date|after_or_equal:today',
        'start_payment_date' => 'required|date|after_or_equal:today',       
        'attachments.*' => 'required|image'
    ];

    public function index(Request $request) 
    {        
        $unit_contract_requests = UnitContractRequest::query();
        $auth_user = $request->user();
      
        if ( $auth_user->hasRole(UserRole::SALE_TEAM_LEADER) ) {
            $agents = User::where("managed_by", $auth_user->id)->pluck('id')->toArray();
            array_push($agents,$auth_user->id);        
            $unit_contract_requests = $unit_contract_requests->agents($agents);            
        } elseif ( $auth_user->hasRole(UserRole::AGENT) ) {
           $unit_contract_requests = $unit_contract_requests->byUserId($auth_user->id);
        } 

        if ( $request->input('status') ) {
            $unit_contract_requests = $unit_contract_requests->where('status',$request->input('status'));
        }

        if ( $request->input('term') ) {           
            $term = $request->input('term');
            $unit_contract_requests = $unit_contract_requests->where(function ($query) use ($term){
                $query->whereHas('unit', function ($query) use ($term) {
                    $query->where('code', 'LIKE', '%'.$term.'%');
                });

                $query->orWhereHas('UnitDepositRequest', function ($query) use ($term) {
                    $query->where('customer_name', 'LIKE', '%'.$term.'%');
                });

                $query->orWhereHas('UnitDepositRequest', function ($query) use ($term) {
                    $query->where('customer_phone_number', 'LIKE', '%'.$term.'%');
                });
            });           
        }

        if ( $request->input('unit_type_id') ) {
            $unit_type_id = $request->input('unit_type_id');
            $unit_contract_requests = $unit_contract_requests->whereHas('unit', function ($query) use ($unit_type_id) {
                return $query->where('unit_type_id', $unit_type_id);
            });
        }elseif ( $request->input('project_id') ) {
            $unit_type_array = \App\UnitType::where('project_id', $request->input('project_id'))->get()->pluck('id');
            $unit_contract_requests = $unit_contract_requests->whereHas('unit', function ($query) use ($unit_type_array) {
                return $query->whereIn('unit_type_id', $unit_type_array);
            });
        }

        if ( $request->input("embed") ) {           
            $relationships = explode(',', trim($request->input('embed')) );
            $unit_contract_requests = $unit_contract_requests->with($relationships);
            // return new UnitContractRequestCollection( $unit_contract_requests->with($relationships)->paginate() ) ; 
        }

        return new UnitContractRequestCollection( $unit_contract_requests->paginate() );
    }

    public function show(Request $request, $id) 
    {
        $unit_contract_request = UnitContractRequest::findOrFail($id);

        if ( $request->input("embed") ) {           
            $relationships = explode(',', trim($request->input('embed')) );
            $unit_contract_request->load($relationships);
        }

        return new UnitContractRequestResource( $unit_contract_request );        
    }

   	public function create(Request $request)
   	{	
   		$validator = Validator::make( $request->all(), $this->getValidationRules());
        if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }
        // validation limit number of files allow to upload
        if ( $request->hasFile('attachments') ) {
            $attachment_validator  =  $this->validateAttachment(count($request->attachments));
            if ( $attachment_validator instanceof \Illuminate\Http\JsonResponse ) {
                return $attachment_validator;
            }         
        } else {
            return $this->sendErrorJsonResponse( __("Attachments are required at least 1 file to be uploaded.") , 422 );
        }
        // Getting the Authenticated User
        $auth_user = $request->user();

        // check if the authenticated user is the owner of Unit Deposit Request
        $unit_deposit_request = UnitDepositRequest::findOrFail($request->unit_deposit_request_id);
        if ( $unit_deposit_request->user_id != $auth_user->id ) {
        	return $this->sendErrorJsonResponse( __("You don't have permission to process your request"), 422);
        } 
        // check if the Unit Deposit Request is approved
        if ( !$unit_deposit_request->isContractRequestable() ) {
        	return $this->sendErrorJsonResponse( __("The deposit is not in the status which allow you to create contract request."), 422);
        }

        // check if the Unit Deposit Request's payment option is selected
        if ( !$unit_deposit_request->is_selected_payment_option ) {
            return $this->sendErrorJsonResponse( __("Payment option cannot be none when requesting contract."), 422);
        }
        // // Check if Unit Deposit Request is fully paid
        // if ( !$unit_deposit_request->isFullyPaid() ) {
        //     return $this->sendErrorJsonResponse( __("The depsoit amount is not fully paid."), 422);
        // }
        // get the data after validation
        $data = array_except($validator->valid(), ['attachments']);
        $data['user_id'] = $auth_user->id;
        $data['status'] = UnitContractStatus::PENDING;
        $data['unit_id'] = $unit_deposit_request->unit_id; 

        try {
        	DB::beginTransaction();
        	// Create Unit Contract Request Object
        	$unit_contract_request = UnitContractRequest::create($data);
        	$unit_contract_request = $unit_contract_request->fresh();
        	// Upload File
        	foreach($request->attachments as $file) {
                $path = $file->store("unit_contract_request","public");
                $unit_contract_request->attachments()->create([
                    'path' => $path,
                ]);
            }
        	// Set Unit Deposit Request's status to RELEAEE
        	$unit_deposit_request->status = UnitDepositStatus::RELEASE;
        	$unit_deposit_request->save();
        	// Create Unit Action 
        	$unit_action = $this->createUnitAction($unit_contract_request, UnitContractStatus::PENDING, $auth_user->id);
        	DB::commit();
        	return new UnitContractRequestResource($unit_contract_request);
        } catch (\Exception $e) {
        	DB::rollback();
        	Log::error($e);
       		return $this->sendErrorJsonResponse( __("Internal Server Error!"), 500);
        }
   	}

    public function cancel(Request $request, $id)
    {

        $validator = Validator::make( $request->all(), [
            'action_reason' => 'required|string|max:191'
        ]);

        $validated_data = $validator->valid();

        if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

        $unit_contract_request = UnitContractRequest::findOrFail($id);
        $unit_deposit_request = UnitDepositRequest::findOrFail($unit_contract_request->unit_deposit_request_id);
        $auth_user = $request->user();

        if ( $unit_contract_request->isStatus(UnitContractStatus::RELEASED) ) {
            return $this->sendErrorJsonResponse( __("This record can not be cancelled."), 422);
        }
        
        try {
            DB::beginTransaction();
            // Set Unit Contract Request's status CANCELLED;
            $unit_contract_request->status = UnitContractStatus::CANCELLED;
            $unit_contract_request->action_reason = $validated_data['action_reason'];
            $unit_contract_request->actioned_user_id = $request->user()->id;
            $unit_contract_request->actioned_at = now();
            $unit_contract_request->save();
            // Set Unit Deposit Request's Status to APPROVED;
            $unit_deposit_request->status = UnitDepositStatus::APPROVED;
            $unit_deposit_request->save();
            // Create Unit Action;
            $unit_action = $this->createUnitAction($unit_contract_request, UnitContractStatus::CANCELLED, $auth_user->id);
            DB::commit();
            return new UnitContractRequestResource($unit_contract_request->fresh());
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e); 
            return $this->sendErrorJsonResponse( __("Internal Server Error!"), 500);
        }
    }

    public function update(Request $request, $id)
    {
        $unit_contract_request = UnitContractRequest::findOrFail($id);
        $auth_user = $request->user();
        
        if ( !$unit_contract_request->isOwner($auth_user->id) ) {
            return $this->sendErrorJsonResponse( __("You don't have permission to process your request"), 403);
        }
        // check if the Unit Contract Request is in the Editable Status
        if ( !$unit_contract_request->isEditable() ) {
            return $this->sendErrorJsonResponse( __("This record is not in the status which allow you to update."), 403);
        }

        $validator = Validator::make( $request->all(), [
            'remark' => 'nullable|string|max:500',
            'signed_at' => 'nullable|date',
            'start_payment_date' => 'nullable|date',
            'deleted_attachments.*' => 'nullable|integer',
            'new_attachments.*' => 'nullable|image'
        ]);
        
        if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

        // Attachments validation
        $new = $request->hasFile('new_attachments') ? count( $request->new_attachments ) : 0 ;
        $deleted = is_null( $request->deleted_attachments ) ? 0 : count($request->deleted_attachments);
        $existing = $unit_contract_request->attachments->count();
              
        $attachment_validator  =  $this->validateAttachment($new + $existing - $deleted);
        if ( $attachment_validator instanceof \Illuminate\Http\JsonResponse ) {
            return $attachment_validator;
        }
        // End Attachments validation
        try {
            DB::beginTransaction();
            // Uploading the New Attachments
            if ( $request->hasFile('new_attachments') ) {
                foreach($request->new_attachments as $file) {
                    $path = $file->store("unit_contract_request","public");
                    $unit_contract_request->attachments()->create([
                        'path' => $path,
                    ]);
                }
            } 
            // Deleting the Deleted Attachment
            if ( $deleted > 0 ) {
                $attachement_id_array = $unit_contract_request->attachments->pluck('id')->toArray();
                foreach( $request->deleted_attachments as $id) {
                    if (in_array($id, $attachement_id_array)){
                        UnitContractRequestAttachment::destroy($id);
                    }
                }
            } 
            // fill and update 
            $validated_data = array_except($validator->valid(),['new_attachments', 'deleted_attachments', '_method']);
            $unit_contract_request->fill($validated_data);
            $unit_contract_request->save();
            DB::commit();
            return new UnitContractRequestResource($unit_contract_request->fresh());  
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->sendErrorJsonResponse(__('Internal Server Error!'), 500);          
        }
    }
    
   	private function createUnitAction(UnitContractRequest $unit_contract_request, $status, $user_id)
   	{
   		return  UnitAction::create([
            'user_id'       =>  $user_id,
            'unit_id'       => $unit_contract_request->unit_id,
            'action'        => $status == 'AVAILABLE' ? 'AVAILABLE' : 'CONTRACT',
            'status_action' => $status == 'AVAILABLE' ? '' :  $status,
            'actionable_type' => $unit_contract_request->getMorphClass(),
            'actionable_id' => $unit_contract_request->id
        ]);
   	}

   	private function validateAttachment($total_attachment_count) 
    {
        if ( $total_attachment_count > 9 ){
            return $this->sendErrorJsonResponse( __("Attachments can not exceed 9 files.") , 422 );
        }
        if ( $total_attachment_count <= 0 ){
            return $this->sendErrorJsonResponse( __("Attachments are required at least 1 file to be uploaded.") , 422 );     
        }
        return true;
    }

   	private function getValidationRules()
    {
        return $this->validationRules;
    }
}
