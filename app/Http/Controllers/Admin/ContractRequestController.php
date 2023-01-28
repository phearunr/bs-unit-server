<?php

namespace App\Http\Controllers\Admin;

use App\ContractRequest;
use App\User;
use App\Helpers\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractRequestController extends Controller
{ 
  protected $validationRules =  [
    'customer1_birthdate' => 'required|date_format:Y-m-d',
    'customer1_nid' => 'required|string|max:100',
    'customer1_nid_issued_date' => 'required|date_format:Y-m-d',
    'customer2_birthdate' => 'nullable|date_format:Y-m-d',
    'customer2_nid' => 'nullable|string|max:100',
    'customer2_nid_issued_date' => 'nullable|date_format:Y-m-d',
    'customer_house_no' => 'required|string|max:100',
    'customer_street' => 'required|string|max:100',
    'customer_phum' => 'required|string|max:200',
    'customer_commune' => 'required|string|max:200',
    'customer_district' => 'required|string|max:200',
    'customer_city' => 'required|string|max:200'   
  ];
  public function index(Request $request)
  {     
    $contract_requests = ContractRequest::query(); 
    // $users = User::has('contractRequests')->get(['id','name']);

    if ( $request->query('from') AND $request->query('to')) {
      $contract_requests = $contract_requests->ofCreatedBetweenDate($request->query('from'), $request->query('to'));
    } else {
      $contract_requests = $contract_requests->ofCreatedBetweenDate();
    }

    if ( $request->query('sm_status') ) {
      $contract_requests = $contract_requests->ofSaleManagerStatus($request->query('sm_status'));
    } else {
      $contract_requests = $contract_requests->ofSaleManagerStatus('');
    }

    if ( $request->query('uc_status') ) {
      $contract_requests = $contract_requests->ofUnitControllerStatus($request->query('uc_status'));
    } else {
      $contract_requests = $contract_requests->ofUnitControllerStatus('');
    }

    if ( $request->query('term') ) {   
      $term = $request->query('term');
      $contract_requests = $contract_requests->where('customer1_name' , 'LIKE', '%'.$term.'%');     
      $contract_requests = $contract_requests->where('customer2_name' , 'LIKE', '%'.$term.'%');
      $contract_requests = $contract_requests->orWhere('customer_phone_number' , 'LIKE', '%'.$term.'%');
      $contract_requests = $contract_requests->orWhere('customer_phone_number2' , 'LIKE', '%'.$term.'%');
      $contract_requests = $contract_requests->orWhere('unit_code' , 'LIKE', '%'.$term.'%');
      $contract_requests = $contract_requests->orWhere('agent_name' , 'LIKE', '%'.$term.'%');
    }

    $contract_requests = $contract_requests->paginate(10);
    return view('admin.contract_request.index', compact('contract_requests'));
  }
  
  public function show($id) 
  {
    $contract_request = ContractRequest::findOrFail($id);
    $payment_option =  $contract_request->paymentOption;
    $payemtn_option_array = [];
    if ( is_null($payment_option) ) {
      $payment_option_array = $contract_request->only('payment_option_id','loan_duration','interest','special_discount','is_first_payment','first_payment_duration','first_payment_percentage','first_payment_amount');
    } else {
      $payment_option_array = $payment_option->getAttributes();
    } 
    return view('admin.contract_request.single', compact('contract_request','payment_option_array'));
  }

  public function update(Request $request, $id)
  {
    if (!Auth::user()->hasRole(UserRole::CONTRACT_CONTROLLER)){
      abort(403);
    }

    $contract_request = ContractRequest::findOrFail($id);        

    $validatedData = $request->validate($this->getValidationRules());
    
    try {
      $contract_request->fill($validatedData);
      $contract_request->save();
      return redirect()->route('admin.contract_request.show', ['id' => $contract_request->id])
      ->with('status', "Contract Request has been created successfully.");
    } catch (\Exception $e) {
      return back()->withInput()->withErrors([ 'contract_request' => $e->getMessage()]);
    }
  }

  public function showMortgage($id) 
  {
    $contract_request = ContractRequest::findOrFail($id);
    $payment_option = $contract_request->paymentOption;
    return view('admin.contract_request.mortgage', compact('contract_request','payment_option'));
  }

  public function getValidationRules() 
  {
    return $this->validationRules;
  }


}
