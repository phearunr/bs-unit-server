<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\PaymentOption;
use App\UnitType;
use App\Http\Resources\PaymentOption as PaymentOptionResource;
use App\Http\Resources\PaymentOptionCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentOptionController extends Controller
{
    protected $validationRules =  [
	    'unit_type_id'		=> 'required|integer|exists:unit_types,id', 
        'name' 				=> 'required|string|max:255', 
        'loan_duration' 	=> 'required|integer|min:0|max:255',
        'interest'			=> 'required|integer|min:0|max:100',
        'special_discount' 	=> 'integer|min:0|max:100'
	];

	public function all(Request $request)
	{
		if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')) );
			return new PaymentOptionCollection( PaymentOption::with($relationships)->get() );
		}
		return new PaymentOptionCollection( PaymentOption::all() );
	}

	public function create(Request $request) 
	{	
		$validator = Validator::make( $request->all(), $this->getValidationRules() );

		if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        try {
        	$payment_option = PaymentOption::create($data);	
        } catch (Exception $e) {
        	$this->sendErrorJsonResponse(__('Internal Server Error!'), 500);
        }
        return new PaymentOptionResource( $payment_option );
	}

	public function get(Request $request, $id)
	{
		$payment_option = PaymentOption::where('id', $id)->firstOrFail();

		if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')) );
			$payment_option->load($relationships);
		}
		return new PaymentOptionResource( $payment_option );
	}

	public function update(Request $request, $id)
	{
		$payment_option = PaymentOption::where('id', $id)->firstOrFail();

		$validator = Validator::make( $request->all(), $this->getValidationRules() );

		if ($validator->fails()) {
            return $this->sendErrorJsonResponse($validator->errors()->first(), 422);
        }

        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        try {
        	$payment_option->fill($data);	
        	if ( ! $payment_option->save() ){
	            $this->sendErrorJsonResponse( __('There are some problems while trying to updating your request'), 500);			
			}

        } catch (Exception $e) {
        	$this->sendErrorJsonResponse(__('Internal Server Error!'), 500);
        }
        return new PaymentOptionResource( $payment_option );
	}

	public function remove(Request $request, $id)
	{
		$payment_option = PaymentOption::where('id', $id)->firstOrFail();
		try {
			$payment_option->user_id = $request->user()->id;
			$payment_option->deleted_at = \Carbon\Carbon::now();
			$payment_option->save();
			return $this->sendSuccessResponse( __("Delete Successful.") , 200);
		} catch (Exception $e) {
			return $this->sendErrorJsonResponse(__('Internal Server Error!'), 500);
		}
	}

	public function getByUnitTypeId(Request $request, $unit_type_id)
	{
		$unit_type = UnitType::findOrFail($unit_type_id);

		if ( $request->input("embed") ) {			
			$relationships = explode(',', trim($request->input('embed')) );
			return new PaymentOptionCollection( PaymentOption::where('unit_type_id', $unit_type_id)->with($relationships)->get() );
		}
		return new PaymentOptionCollection( PaymentOption::where('unit_type_id', $unit_type_id)->get() );
	}

	public function getValidationRules(){
	  	return $this->validationRules;
	}

	public static function validatedPaymentOptionFromRequest(Array $data) {
		$default_payment_option = [
			"payment_option_id" => null,
			"loan_duration" => 0,
			"interest" => 0,
			"special_discount" => 0,
			"is_first_payment" => 0,
			"first_payment_duration" => 0,
			"first_payment_percentage" => 0,
			"first_payment_amount" => 0,
		];
		if ( array_key_exists("payment_option_id", $data) ) {			
			$data['loan_duration'] = 0;
			$data['interest'] = 0;
			$data['special_discount'] = 0;
			$data['is_first_payment'] = 0;
			$data['first_payment_duration'] = 0;
			$data['first_payment_percentage'] = 0;
			$data['first_payment_amount'] = 0;
		} else {
			$data['payment_option_id'] = null;
			$data['loan_duration'] = $data['loan_duration'] ?? 0;
			$data['interest'] =  $data['interest'] ?? 0;
			$data['special_discount'] = $data['special_discount'] ?? 0;
			$data['is_first_payment'] = $data['is_first_payment'] ?? 0;
			$data['first_payment_duration'] = $data['first_payment_duration'] ?? 0;
			$data['first_payment_percentage'] =  $data['first_payment_percentage'] ?? 0;
			$data['first_payment_amount'] = $data['first_payment_amount'] ?? 0;
		}
		return $data;
	}
}
