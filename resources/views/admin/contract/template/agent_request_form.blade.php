<!DOCTYPE html>
<html lang="km">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contract Request - {{ $unit_deposit_request->customer_name }}</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/contract_print_v2.css') }}">
</head>
<body>
<div id="app">
    <div class="container-fluid">
        <h4 class="main-title text-center mb-4">ពត៌មានសម្នើររបស់ភ្នាក់ងារលក់</h4>
        <h5 id="customer-information">{{ __("Customer Information") }}:</h5>    
        <div class="row">                       
            <div class="col-9 form-group">
                <label for="customer_name">{{ __("Customer Name") }}:</label>
                <input type="text" class="form-control" id="customer_name" value="{{ $unit_deposit_request->customer_name }}" readonly="readonly">
            </div>                       
            <div class="col-3 form-group">
                <label for="customer_gender">{{ __("Gender") }}:</label>
                <input type="text" class="form-control" id="customer_gender" value="{{ \App\Helpers\GenderHelper::getGenderText($unit_deposit_request->customer_gender) }}" readonly="readonly">
            </div>      
        </div>
        <div class="row">                        
            <div class="col-6 form-group">
                <label for="customer_phone_number">{{ __("Phone Number") }} ({{ __("1st Line") }}):</label>
                <input type="text" class="form-control" id="customer_phone_number" value="{{ $unit_deposit_request->customer_phone_number }}" readonly="readonly">
            </div>                     
            <div class="col-6 form-group">
                <label for="customer_phone_number2">{{ __("Phone Number") }} ({{ __("2nd Line") }}):</label>
                <input type="text" class="form-control" id="customer_phone_number2" value="{{ $unit_deposit_request->customer_phone_number2 }}" readonly="readonly">
            </div>                       
        </div>
        <h5 id="unit-information">{{ __("Unit Information") }}:</h5>
        <hr class="mt-0">
        <div class="row">
            <div class="col-4 form-group">
                <label for="unit_code">{{ __("Unit Code") }}:</label>
                <input type="text" class="form-control" id="unit_code" value="{{ $unit->code }}" readonly="readonly">
            </div>
            <div class="col-4 form-group">
                <label for="unit_type_name">{{ __("Unit Type") }}:</label>
                <input type="text" class="form-control" id="unit_type_name" value="{{ $unit->unitType->name }}" readonly="readonly">
            </div>
            <div class="col-4 form-group">
                <label for="project_name">{{ __("Project") }}:</label>
                <input type="text" class="form-control" id="project_name" value="{{ $unit->unitType->project->name }}" readonly="readonly">
            </div>
        </div>
        <h5 id="pricing-information">{{ __("Pricing Information") }}:</h5>
        <hr class="mt-0">  
        <div class="row">                        
            <div class="col-4 form-group">
                <label for="unit_sale_price">{{ __("Unit Sale Price") }}:</label>
                <input type="text" class="form-control" id="unit_sale_price" value="{{ number_format($unit_deposit_request->unit_sale_price) }}" readonly="readonly">
            </div>
            <div class="col-4 form-group">
                <label for="discount_promotion">{{ __("Discount Promotion") }}:</label>
                <input type="text" class="form-control" id="discount_promotion" value="{{ number_format($unit_deposit_request->discount_promotion) }}" readonly="readonly">
            </div>
            <div class="col-4 form-group">
                <label for="other_discount_allowance">{{ __("Other Discount Allowed") }}:</label>
                <input type="text" class="form-control" id="other_discount_allowance" value="{{ number_format($unit_deposit_request->other_discount_allowance) }}" readonly="readonly">
            </div>
        </div>
        <div class="row">
            <div class="col-4 form-group">                          
                <label for="deposit_amount">{{ __("Deposited Amount") }}:</label>
                <input type="text" class="form-control" id="deposit_amount" value="{{ number_format($unit_contract_request->unitDepositRequest->deposit_amount) }}" readonly="readonly">
            </div>
            <div class="col-4 form-group">                          
                <label for="deposited_at">{{ __("Deposited At") }}:</label>
                <input type="text" class="form-control" id="deposited_at" value="{{ $unit_deposit_request->deposited_at->toSystemDateString() }}" readonly="readonly">
            </div>
            <div class="col-4 form-group">                          
                <label for="receiving_amount">{{ __("Received Amount") }}:</label>
                <input type="text" class="form-control" id="receiving_amount" value="{{ number_format($unit_deposit_request->receiving_amount) }}" readonly="readonly">
            </div>
        </div>
        <h5 id="payment-option">{{ __("Payment Option") }}:</h5>
        <hr class="mt-0">     
        <div class="row">
            <div class="col-6 form-group">
                <label for="payment_option">{{ __("Selected Payment Option") }}:</label>
                <input type="text" class="form-control" id="payment_option" value="{{ empty($payment_option_array['id']) ? 'Other' : $payment_option_array['name'] }}" readonly="readonly">
            </div>
            <div class="col-3 form-group">
                <label for="payment_day">{{ __("Start Payment Date") }}:</label>
                <input type="text" class="form-control" id="start_payment_date" value="{{ $unit_contract_request->start_payment_date->toSystemDateString() }}" readonly="readonly">
            </div>
            <div class="col-3 form-group">
                <label for="sign_date">{{ __("Signed At") }}:</label>
                <input type="text" class="form-control" id="sign_date" value="{{ $unit_contract_request->signed_at->toSystemDateString() }}" readonly="readonly">
            </div>
        </div>
        <div class="row">
            <div class="col-4 form-group">
                <label for="loan_duration">{{ __("Loan Duration") }}:</label>
                <input type="text" id="loan_duration" class="form-control" value="{{ $payment_option_array['loan_duration'] }}" readonly="readonly" />
            </div>
            <div class="col-4 form-group">
                <label for="interest">{{ __("Interest Rate") }}:</label>
                <input type="text" id="interest" class="form-control" value="{{ $payment_option_array['interest'] }}" readonly="readonly" />
            </div>
            <div class="col-4 form-group">
                <label for="special_discount">{{ __("Discount Payment Option %") }}:</label>
                <input type="text" id="special_discount" class="form-control" value="{{ $payment_option_array['special_discount'] }}" readonly="readonly" />
            </div>
        </div>  
        <div class="row">
            <div class="col-4 form-group">
                <label for="is_first_payment">{{ __("Has First Payment?") }}</label>
                <input type="text" id="is_first_payment" class="form-control" value="{{ $payment_option_array['is_first_payment'] ? 'Yes' : 'No'}}" readonly="readonly" />
            </div>
            <div class="col-4 form-group">
                <label for="first_payment_duration">{{ __("First Payment Duration") }}:</label>
                <input type="text" id="first_payment_duration" class="form-control" value="{{ $payment_option_array['first_payment_duration'] }}" readonly="readonly" />
            </div>
            <div class="col-4 form-group">
                <label for="first_payment_amount">{{ isset($payment_option_array['first_payment_percentage']) ? __("First Payment Percentage") : __("First Payment Amount") }}</label>
                <input type="text" id="first_payment_amount" class="form-control" value="{{ isset($payment_option_array['first_payment_percentage']) ? $payment_option_array['first_payment_percentage']  : $payment_option_array['first_payment_amount'] }}" readonly="readonly" />
            </div>
        </div>
        <h5 id="agent-information">{{ __("Agent Information") }}:</h5>
        <hr class="mt-0">
        <div class="row">
            <div class="col-4 form-group">
                <label for="agent_name">{{ __("Agent Name") }}:</label>
                <input type="text" id="agent_name" class="form-control" value="{{ $agent->name }}" readonly="readonly">
            </div>
            <div class="col-4 form-group">
                <label for="agent_phone_number">{{ __("Agent Name") }}:</label>
                <input type="text" id="agent_phone_number" class="form-control" value="{{ $agent->phone_number }}" readonly="readonly">
            </div>
            <div class="col-4 form-group">
                <label for="sale_team_leader">{{ __("Sale Team Leader") }}:</label>
                <input type="text" id="sale_team_leader" class="form-control" value="{{ $sale_team_leader ? $sale_team_leader->name : 'N/A' }}" readonly="readonly">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 form-group">
                <label for="remark">{{ __("Agent Remark") }}:</label>
                <input type="text" id="remark" class="form-control" value="{{ $unit_contract_request->remark }}"  readonly="readonly">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="font-weight-bold p-0" height="100px">Requested by:</td>
                            <td class="text-center p-0 font-weight-bold">Checked by:</td>
                            <td class="text-right p-0 font-weight-bold">Approved by:</td>
                        </tr>
                        <tr>
                            <td class="p-0">Sale/Agent</td>
                            <td class="p-0 text-center">Contract Dept.</td>
                            <td class="p-0 text-right">Sale Dept.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>