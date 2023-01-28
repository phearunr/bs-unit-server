<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Unit;
use App\UnitAction;
use App\UnitHoldRequest;
use App\UnitDepositRequest;
use App\Helpers\UnitHoldStatus;
use App\Helpers\UnitDepositStatus;
use App\Http\Resources\UnitDepositRequest as UnitDepositRequestResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConvertUnitHoldToUnitDepositController extends Controller
{
    public function create(Request $request, $id) 
    {
    	$unit_hold_request = UnitHoldRequest::findOrFail($id);
    	$auth_user = $request->user();

    	$validator = Validator::make($request->all(), [
	        'other_discount_allowance' => 'bail|required|numeric|min:0|max:999999999.99',
	        'deposit_amount' => 'bail|required|numeric|min:0|max:999999999.99',  
	        'payment_option_id' => 'bail|nullable|integer|exists:payment_options,id',
	    	'loan_duration' => 'bail|required_without:payment_option_id|integer|min:0',
	        'interest' => 'bail|required_without:payment_option_id|numeric|min:0',
	        'special_discount' => 'bail|required_without:payment_option_id|numeric|min:0|max:100',
	        'is_first_payment' => 'bail|required_without:payment_option_id|boolean',
	        'first_payment_duration' => 'bail|required_without_all:payment_option_id|integer|min:0',
	        'first_payment_percentage' => 'bail|required_without_all:first_payment_amount,payment_option_id|numeric|min:0|max:100',
	        'first_payment_amount' => 'bail|required_without_all:first_payment_percentage,payment_option_id|numeric|min:0',
	    	'customer_name' => 'bail|required|string|min:4|max:255', 
	    	'customer_gender' => 'bail|required|integer|min:1|max:2',
	    	'customer_phone_number' => 'bail|required|regex:(^0\d{8,9}$)',
	    	'customer_phone_number2' => 'bail|nullable|regex:(^0\d{8,9}$)',
    	]);

        if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

       	// check the request is approved
    	if ( strcasecmp($unit_hold_request->status, UnitHoldStatus::APPROVED) != 0 ) {
    		return $this->sendErrorJsonResponse( __("Unit Hold Request has not been approved yet."), 422);
    	}
    	// check if owner
    	if ( $auth_user->id != $unit_hold_request->user_id ) {
    		return $this->sendErrorJsonResponse( __("You don't have permission to process your request"), 422);
    	}

    	$validated_data = $validator->valid();
    	$unit  = Unit::find($unit_hold_request->unit_id);
    	// get discount promotion of the unit
    	$discount_promotion = $unit->unitType
                                   ->discountPromotion()
                                   ->where("start_date", "<=", Carbon\Carbon::today())
                                   ->where('end_date', ">=", Carbon\Carbon::today())
                                   ->first(); 

    	// Appending addtional data
    	$validated_data['user_id'] = $auth_user->id;
    	$validated_data['unit_id'] = $unit_hold_request->unit_id;
        $validated_data['unit_sale_price'] = $unit->price;
        $validated_data['status'] = "PENDING";
        $validated_data['deposited_at'] = now();
        $validated_data['discount_promotion'] = ( is_null($discount_promotion) ? 0 : $discount_promotion->amount );

        try {
            DB::beginTransaction();
            $unit_deposit_request = UnitDepositRequest::create($validated_data);
            
            $unit_hold_request->status = UnitHoldStatus::RELEASE;
            $unit_hold_request->save()

            $action = UnitAction::create([
                'user_id' => $auth_user->id,
                'unit_id' => $unit->id,
                'action' => 'DEPOSIT',
                'status_action' => UnitDepositStatus::PENDING,
                'actionable_type' => $unit_deposit_request->getMorphClass(),
                'actionable_id' => $unit_deposit_request->id
            ]);
            // Queue to release after the provided day
            // ProcessUnitHold::dispatch($unit_deposit_request)
            //                    ->delay(now()->addDays($validated_data['hold_day']));
          
             // Send Notification
            $users_need_to_be_notified = User::role([UserRole::UNIT_CONTROLLER])->get();
            UnitDepositRequestNotificationController::sendUnitDepositPendingRequest($users_need_to_be_notified,$unit_deposit_request)
            
            DB::commit();
            return new UnitDepositRequestResource($unit_deposit_request->fresh());
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendErrorJsonResponse($e->getMessage(), 500);
            // Log::error($e->getMessage());
            // return $this->sendErrorJsonResponse("Internal System Error!", 500);
        }
    }
}
