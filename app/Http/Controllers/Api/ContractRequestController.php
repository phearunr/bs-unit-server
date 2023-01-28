<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\User;
use App\Project;
use App\UnitType;
use App\PaymentOption;
use App\ContractRequest;
use App\ContractRequestAttachment;
use App\Notifications\ContractRequestEdited;
use App\Notifications\ContractRequestCreated;
use App\Notifications\ContractRequestApproved;
use App\Notifications\ContractRequestRejected;
use App\Notifications\ContractRequestEditedBySaleManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContractRequest as ContractRequestResource;
use App\Http\Resources\ContractRequestCollection;
use Spatie\Permission\Models\Role;
use App\Helpers\UserRole;
// use Illuminate\Validation\Rule;
// use Illuminate\Validation\ValidationException;

class ContractRequestController extends Controller
{   
    protected $validationRules =  [    
        'customer1_name'        => 'required|string|min:4|max:255',
        'customer1_gender'      => 'required|integer|min:1|max:2',
        'customer2_name'        => 'nullable|string|min:4|max:255',
        'customer2_gender'      => 'nullable|integer|min:0|max:2',
        'customer_phone_number' => 'required|regex:(^0\d{8,9}$)',
        'customer_phone_number2' => 'nullable|regex:(^0\d{8,9}$)',
        'agent_name'            => 'required|string|min:4|max:255',
        'agent_gender'          => 'required|integer|min:1|max:2',
        'agent_phone_number'    => 'required|regex:(^0\d{8,9}$)',
        'agent_remark'          => 'nullable|string|max:500',
        'sale_team_leader_id'   => "required|integer|exists:users,id",
        'unit_sold_date'        => 'required|date',    
        'unit_id'               => 'required|integer|exists:units,id',
        'unit_sold_price'       => 'required|numeric|min:0|max:999999999.99',
        'discount_promotion'    => 'nullable|numeric|min:0|max:999999999.99',
        'other_discount_allowed' => 'nullable|numeric|min:0|max:999999999.99',
        'unit_remark'           => 'nullable|string|max:500',
        'deposited_amount'      => 'required|numeric|min:0|max:999999999.99',
        'deposited_date'        => 'required|date',
        'start_payment_date'    => 'required|date|after_or_equal:deposited_date',   
        'payment_option_id'     => 'integer|exists:payment_options,id',
        "loan_duration"         => 'required_without:payment_option_id|integer|min:0',
        "interest"              => 'required_without:payment_option_id|numeric|min:0',
        'special_discount'      => 'required_without:payment_option_id|numeric|min:0|max:100',
        'is_first_payment'      => 'required_without:payment_option_id|boolean',
        'first_payment_duration' => 'required_without:payment_option_id|integer|min:0',
        'first_payment_percentage' => 'nullable|numeric|min:0|max:100',
        'first_payment_amount'  => 'nullable|numeric|min:0',
        'sign_date'             => 'required|date|after_or_equal:today',
        'attachments.*'         => 'required|image'
    ];

    public function all(Request $request)
    {
        $paginate = 20;  
        $auth_user = User::findOrFail($request->user()->id);
        
        if ( $auth_user->hasRole(UserRole::AGENT."|".UserRole::SALE_TEAM_LEADER) ) {
            return new ContractRequestCollection(ContractRequest::ownerOnly()->paginate($paginate));
        }
        
        return new ContractRequestCollection(ContractRequest::paginate($paginate));
    }

    public function get(Request $request, $id)
    {   
        $contract_request = ContractRequest::findOrFail($id);
        
        $auth_user = User::findOrFail($request->user()->id);

        if ( $auth_user->hasRole(UserRole::AGENT) ) {
            if ( !$contract_request->isOwner() ){
               throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
            }
        }

        // Relationship automatically load in Model
        return new ContractRequestResource($contract_request);
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
            return $this->sendErrorJsonResponse( __("Attachments is required at least 1 file to be uploaded") , 422 );
        }
        // End validation limit number of files allow to upload

        $data = $request->except('attachments');

        if ( !is_null($request->payment_option_id) ) {
            $data['loan_duration'] = null;
            $data['interest'] = null;
            $data['is_first_payment'] = false;
            $data['special_discount'] = null;
            $data['first_payment_duration'] = null;
            $data['first_payment_percentage'] = null;
            $data['first_payment_amount'] = null;
        }   
        
        $data['user_id'] = $request->user()->id;

        try {
            $contract_request = ContractRequest::create($data);  
          
            foreach($request->attachments as $file) {
                $path = $file->store("contract_request","public");
                $contract_request->attachments()->create([
                    'path' => $path,
                ]);
            }
            return new ContractRequestResource( $contract_request->fresh() );
        } catch (\Exception $e) {
            if ( isset($contract_request) ) {
                $contract_request->delete();    
            }
            return $this->sendErrorJsonResponse(__('Internal Server Error!'.$e->getMessage()), 500);
        } finally {
            if ( isset( $contract_request ) ){
                $this->sendCreatedNotification($contract_request);
            }            
        }
    }

    public function update(Request $request, $id)
    {
        $contract_request = ContractRequest::findOrFail($id);
        // Version 1
        // if ( ! $contract_request->isEditable() ) {
        //     return $this->sendErrorJsonResponse( __("You don't have permission to process your request") , 403 );
        // }

        // if ( ! $contract_request->isOwner() ) {
        //     return $this->sendErrorJsonResponse( __("You don't have permission to process your request") , 403 );
        // }
        // End Version 1
        // Version 2
        if ( !$contract_request->isUpdatable() ){
            return $this->sendErrorJsonResponse( __("You don't have permission to process your request") , 403 );
        }
        // End Version 2

        $validator = Validator::make( $request->all(),[
            'customer1_name'        => 'string|min:4|max:255',
            'customer1_gender'      => 'integer|min:1|max:2',
            'customer2_name'        => 'nullable|string|min:4|max:255',
            'customer2_gender'      => 'nullable|integer|min:0|max:2',
            'customer_phone_number' => 'regex:(^0\d{8,9}$)',
            'customer_phone_number2' => 'regex:(^0\d{8,9}$)',
            'agent_name'            => 'string|min:4|max:255',
            'agent_gender'          => 'integer|min:1|max:2',
            'agent_phone_number'    => 'regex:^0\d{8,9}^',
            'agent_remark'          => 'nullable|string|max:500',
            'sale_team_leader_id'   => "integer|exists:users,id",
            'unit_sold_date'        => 'date',
            'unit_id'               => 'integer|exists:units,id',
            'unit_sold_price'       => 'numeric|min:0|max:999999999.99',
            'discount_promotion'    => 'nullable|numeric|min:0|max:999999999.99',
            'other_discount_allowed' => 'nullable|numeric|min:0|max:999999999.99',
            'unit_remark'           => 'nullable|string|max:500',
            'deposited_amount'      => 'numeric|min:0|max:999999999.99',
            'deposited_date'        => 'date',
            'start_payment_date'    => 'date|after_or_equal:deposited_date',
            'payment_option_id'     => 'integer|exists:payment_options,id',
            'loan_duration'         => 'required_without:payment_option_id|integer|min:0',
            'interest'              => 'required_without:payment_option_id|numeric|min:0',
            'special_discount'      => 'required_without:payment_option_id|numeric|min:0|max:100',
            'is_first_payment'      => 'required_without:payment_option_id|boolean',
            'first_payment_duration'=> 'required_without:payment_option_id|integer|min:0',
            'first_payment_percentage' => 'nullable|numeric|min:0|max:100',
            'first_payment_amount'  => 'nullable|numeric|min:0',
            'sign_date'             => 'date|after_or_equal:today',
            'deleted_attachments.*' => 'nullable|integer',
            'new_attachments.*'     => 'nullable|image'
        ]);

        if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }    

        $data = $request->except(['new_attachments', 'deleted_attachments', '_method']);
        if ( !is_null($request->payment_option_id) ) {
            $data['loan_duration'] = null;
            $data['interest'] = null;
            $data['is_first_payment'] = false;
            $data['special_discount'] = null;
            $data['first_payment_duration'] = null;
            $data['first_payment_percentage'] = null;
            $data['first_payment_amount'] = null;
        } else {
            $data['payment_option_id'] = null;
        }        
        // Attachments validation
        $new = $request->hasFile('new_attachments') ? count( $request->new_attachments ) : 0 ;
        $deleted = is_null( $request->deleted_attachments ) ? 0 : count($request->deleted_attachments);
        $existing = $contract_request->attachments->count();
              
        $attachment_validator  =  $this->validateAttachment($new + $existing - $deleted);
        if ( $attachment_validator instanceof \Illuminate\Http\JsonResponse ) {
            return $attachment_validator;
        }
        // End Attachments validation

        // Uploading the New Attachments
        try {
            if ( $request->hasFile('new_attachments') ) {
                foreach($request->new_attachments as $file) {
                    $path = $file->store("contract_request","public");
                    $contract_request->attachments()->create([
                        'path' => $path,
                    ]);
                }
            }    
        } catch (\Exception $e) {
            return $this->sendErrorJsonResponse(__('Internal Server Error!'), 500);           
        }        
        // End Uploading the New Attachments

        // Deleting the Deleted Attachment
        try {
            if ( $deleted > 0 ) {   
                $attachement_id_array = $contract_request->attachments->pluck('id')->toArray();
                foreach( $request->deleted_attachments as $id) {
                    if (in_array($id, $attachement_id_array)){
                        ContractRequestAttachment::destroy($id);
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->sendErrorJsonResponse(__('Internal Server Error!'), 500);           
        }

        try {
            $contract_request->fill($data);           
            $contract_request->save();
            return new ContractRequestResource($contract_request->fresh());
        } catch (\Exception $e) {         
            return $this->sendErrorJsonResponse(__('Internal Server Error!'), 500);         
        } finally {
            if( isset($contract_request) ) {
                $this->sendEditedNotification( $contract_request );
            }
        }
    }

    public function approve(Request $request, $id)
    {
        $contract_request = ContractRequest::findOrFail($id);
        $auth_user = User::findOrFail($request->user()->id);

        if ( $auth_user->hasRole(UserRole::UNIT_CONTROLLER) ) {
            if ( $contract_request->unit_controller_status == "PENDING" ) {
                $contract_request->unit_controller_approved = $auth_user->id;
                $contract_request->unit_controller_approved_date = \Carbon\Carbon::now();
            }else{
                return $this->sendErrorJsonResponse( __('This record is already either approved or rejected.') , 422 );
            }
        }

        if ( $auth_user->hasRole(UserRole::SALE_MANAGER) ) {
            if ( $contract_request->sale_manager_status == 'PENDING' ) {
                $contract_request->sale_manager_approved = $auth_user->id;
                $contract_request->sale_manager_approved_date = \Carbon\Carbon::now();
            }else{
                return $this->sendErrorJsonResponse( __('This record is already either approved or rejected.') , 422 );
            }
        }

        try {            
            $contract_request->save();            
            return new ContractRequestResource($contract_request);            
        } catch (\Exception $e) {
            return $this->sendErrorJsonResponse($e->getMessage(),500);
        } finally {
            if ( isset($contract_request) ) {
                $this->sendApprovedNotification($contract_request);
            }                        
        }
    }

    public function reject(Request $request, $id)
    {
        $contract_request = ContractRequest::findOrFail($id);
        $auth_user = User::findOrFail($request->user()->id);

        if ( $auth_user->hasRole(UserRole::UNIT_CONTROLLER) ) {
            if ( $contract_request->unit_controller_status == "PENDING" ) {
                $contract_request->unit_controller_rejected = $auth_user->id;
                $contract_request->unit_controller_rejected_date = \Carbon\Carbon::now();              
              
            }else{
                return $this->sendErrorJsonResponse( __('This record is already either approved or rejected.') , 422 );
            }
        }

        if ( $auth_user->hasRole(UserRole::SALE_MANAGER) ) {
            if ( $contract_request->sale_manager_status == 'PENDING' ) {
                $contract_request->sale_manager_rejected = $auth_user->id;
                $contract_request->sale_manager_rejected_date = \Carbon\Carbon::now();
            }else{
                return $this->sendErrorJsonResponse( __('This record is already either approved or rejected.') , 422 );
            }
        }

        try {            
            $contract_request->save();            
            return new ContractRequestResource($contract_request);            
        } catch (\Exception $e) {
            return $this->sendErrorJsonResponse($e->getMessage(),500);
        } finally {
            $this->sendRejectedNotification($contract_request);
        }
    }

    public function updateBySaleManager(Request $request, $id)
    {
        $contract_request = ContractRequest::findOrFail($id);
        $auth_user = User::findOrFail($request->user()->id);

        if ( ! $auth_user->hasRole(UserRole::SALE_MANAGER) ) {
            return $this->sendErrorJsonResponse(__("You don't have permission to process your request"), 403);
        }

        if ( !$contract_request->isEditable() ){
            return $this->sendErrorJsonResponse(__("You are not allowed to edit this record."), 403);
        }

        $validator = Validator::make($request->all(), [
            'discount_promotion' => 'numeric|min:0|max:999999999.99' ,
            'other_discount_allowed' => 'numeric|min:0|max:999999999.99',
            'payment_option_id' => 'required|integer|exists:payment_options,id'
        ]);
        if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }
        try {
            $contract_request->fill($request->only(['discount_promotion','other_discount_allowed','payment_option_id']));            
            $contract_request->save();
            return new ContractRequestResource($contract_request->refresh());
        } catch (\Exception $e) {
            return $this->sendErrorJsonResponse(__('Internal Server Error!'), 500);
        } finally {
            $this->SendEditeBySaleManagerNotification($contract_request);
        }
    }

    public function getReferenceData(Request $request) 
    {
    	$data = [];
    	// Get All Projects
    	$data['projects'] = Project::all();
    	// Get All Unit Types
    	$data['unit_types'] = UnitType::all();
    	// Get All Payment Option
    	$data['payment_options'] = PaymentOption::all();
    	// Get All Sale Team leader
    	$role = Role::findByName(UserRole::SALE_MANAGER,'web');
    	$data['sale_team_leader'] = $role->users()->get(['id','name']);

    	return $this->sendSuccessResponse( __("Success.") , 200, $data );
    }

    public function validateAttachment($total_attachment_count) 
    {
        if ( $total_attachment_count > 9 ){
            return $this->sendErrorJsonResponse( __("Attachments can not exceed 9 files.") , 422 );
        }
        if ( $total_attachment_count <= 0 ){
            return $this->sendErrorJsonResponse( __("Attachments is required at least 1 file to be uploaded.") , 422 );     
        }
        return true;
    }

    private function sendEditedNotification(ContractRequest $contract_request)
    {
        try {            
            if ( $contract_request->other_discount_allowed > 0 || is_null($contract_request->payment_option_id)) {
                $users_need_to_be_notified = User::role([UserRole::ADMINISTRATOR, UserRole::SALE_MANAGER, UserRole::UNIT_CONTROLLER])->get();
            } else {
                
                $users_need_to_be_notified = User::role([UserRole::ADMINISTRATOR, UserRole::UNIT_CONTROLLER])->get();
            }
            Notification::send($users_need_to_be_notified, new ContractRequestEdited($contract_request));          
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }  
    }

    private function sendCreatedNotification(ContractRequest $contract_request)
    {
        try {
            if ( $contract_request->other_discount_allowed > 0 || is_null($contract_request->payment_option_id)) {
                $users_need_to_be_notified = User::role([UserRole::ADMINISTRATOR, UserRole::SALE_MANAGER, UserRole::UNIT_CONTROLLER])->get();
            } else {
                
                $users_need_to_be_notified = User::role([UserRole::ADMINISTRATOR, UserRole::UNIT_CONTROLLER])->get();
            }
            Notification::send($users_need_to_be_notified, new ContractRequestCreated($contract_request));          
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    private function sendRejectedNotification(ContractRequest $contract_request)
    {
        try {           
            $owner = User::where('id', $contract_request->user_id)->first();
            $owner->notify(new ContractRequestRejected($contract_request));
            $users_need_to_be_notified = User::role([UserRole::ADMINISTRATOR])->get();
            Notification::send($users_need_to_be_notified, new ContractRequestRejected($contract_request));          
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }  
    }

    private function sendApprovedNotification(ContractRequest $contract_request)
    {
        try {           
            $owner = User::where('id', $contract_request->user_id)->first();
            $owner->notify(new ContractRequestApproved($contract_request));
            $users_need_to_be_notified = User::role([UserRole::ADMINISTRATOR])->get();
            Notification::send($users_need_to_be_notified, new ContractRequestApproved($contract_request));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    private function SendEditeBySaleManagerNotification(ContractRequest $contract_request)
    {
        try {           
            $owner = User::where('id', $contract_request->user_id)->first();
            $owner->notify(new ContractRequestEditedBySaleManager($contract_request));
            $users_need_to_be_notified = User::role([UserRole::ADMINISTRATOR])->get();
            Notification::send($users_need_to_be_notified, new ContractRequestEditedBySaleManager($contract_request));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function getValidationRules()
    {
        return $this->validationRules;
    }
}