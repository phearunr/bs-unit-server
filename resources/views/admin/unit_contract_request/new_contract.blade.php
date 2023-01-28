@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.contracts.create') }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data" id="create-contract-form">
        <input type="hidden" name="unit_contract_request_id" value="{{ $unit_contract_request->id }}">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">{{__("Create New ")}} {{ __("Contract") }}</div>
                    <div class="card-body p-0">   
                        @if ($errors->any())                            
                            <div class="alert alert-danger mb-0" role="alert">
                                There are some data which is not match the system's requirement, please check again.
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif 
                        <ul class="nav nav-tabs nav-tabs-full" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="customer-tab" data-toggle="tab" href="#customer" role="tab" aria-controls="customer" aria-selected="true">Customer Info.</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="agent-tab" data-toggle="tab" href="#agent" role="tab" aria-controls="agent" aria-selected="true">{{ __('Sale Info.') }}</a>
                            </li>                            
                            <li class="nav-item">
                                <a class="nav-link" id="discount-payment-tab" data-toggle="tab" href="#discount-payment" role="tab" aria-controls="discount-payment" aria-selected="false">Pricing & Payment Term</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Attachments</a>
                            </li>
                        </ul>
                        <div class="tab-content p-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                                <h5 id="customer-information">{{ __("Customer Information") }}:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg-6 form-group">
                                        <label for="customer1_name">{{ __("Customer (1) name") }}:</label>
                                        <input type="text" name="customer1_name" id="customer1_name" 
                                            value="{{ old('customer1_name') ? old('customer1_name') : $unit_deposit_request->customer_name }}"
                                            class="form-control{{ $errors->has('customer1_name') ? ' is-invalid' : '' }}">
                                        @if(  $errors->has('customer1_name'))
                                        <div class="invalid-feedback">{{ $errors->first('customer1_name') }}</div> 
                                        @endif 
                                    </div>  
                                    <div class="col-lg-3 form-group">
                                        <label for="customer1_gender">{{ __("Gender") }}:</label>
                                        <select class="form-control" name="customer1_gender" id="customer1_gender">
                                            <option value="1" {{ old('customer1_gender') == 1 ? 'selected' : $unit_deposit_request->gender == 1 ? 'select' : '' }}>Male</option>
                                            <option value="2" {{ old('customer1_gender') == 2 ? 'selected' : $unit_deposit_request->gender == 1 ? 'select' : ''  }}>Female</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <label for="customer1_birthdate">{{ __("Date of Birth") }}:</label>
                                        <input type="text" class="form-control datepicker" name="customer1_birthdate" id="customer1_birthdate" 
                                            value="{{ old('customer1_birthdate') ? old('customer1_birthdate') : date(config('app.php_date_format')) }}">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="customer1_nid">{{ __("Identity Number") }}:</label>
                                        <input type="text" name="customer1_nid" id="customer1_nid" 
                                            value="{{ old('customer1_nid') }}"
                                            class="form-control{{ $errors->has('customer1_nid') ? ' is-invalid' : '' }}" >
                                        @if(  $errors->has('customer1_nid'))
                                        <div class="invalid-feedback">{{ $errors->first('customer1_nid') }}</div> 
                                        @endif 
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="customer1_nid_issued_date">{{ __("ID Issued Date") }}:</label>
                                        <input type="text" class="form-control datepicker" name="customer1_nid_issued_date" id="customer1_nid_issued_date" value="{{ old('customer1_nid_issued_date') ? old('customer1_nid_issued_date') : date(config('app.php_date_format')) }}">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="customer1_nationality">{{ __("Nationality") }}:</label>
                                        <input type="text" class="form-control" name="customer1_nationality" id="customer1_nationality" value="{{ old('customer1_nationality') ?? 'ខ្មែរ' }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check pb-2">
                                            <input type="checkbox" class="form-check-input" name="second_customer" id="second_customer" {{ old('second_customer') ? 'checked' : $unit_deposit_request->isContainCustomer2() ? 'checked' : '' }}>
                                            <label class="form-check-label text-primary" for="second_customer">{{ __("This contract will contain 2 customers") }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row collapse{{ old('second_customer') ? ' show' : '' }}" id="second_customer_container">
                                    <div class="col-lg-6 form-group">
                                        <label for="customer1_name">{{ __("Customer (2) name") }}:</label>
                                        <input type="text" class="form-control" name="customer2_name"  id="customer2_name" value="{{ old('customer2_name') ?? $unit_deposit_request->customer2_name }}">
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <label for="customer2_gender">{{ __("Gender") }}:</label>
                                        <select class="form-control" name="customer2_gender" id="customer2_gender">
                                            <option value="1" {{ (old('customer2_gender') ?? $unit_deposit_request->customer2_gender) == 1 ? 'selected' : '' }}>Male</option>
                                            <option value="2" {{ (old('customer2_gender') ?? $unit_deposit_request->customer2_gender) == 2 ? 'selected' : '' }}>Female</option>
                                        </select>  
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <label for="customer2_birthdate">{{ __("Date of Birth") }}:</label>
                                        <input type="text" class="form-control datepicker" name="customer2_birthdate" id="customer2_birthdate" value="{{ old('customer2_birthdate') ? old('customer2_birthdate') : date(config('app.php_date_format')) }}">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="customer2_nid">{{ __("Identity Number") }}:</label>
                                        <input type="text" class="form-control" name="customer2_nid" id="customer2_nid" value="{{ old('customer2_nid') }}">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="customer2_nid_issued_date">{{ __("ID Issued Date") }}:</label>
                                        <input type="text" class="form-control datepicker" name="customer2_nid_issued_date" id="customer2_nid_issued_date" value="{{ old('customer2_nid_issued_date') ?  old('customer2_nid_issued_date') : date(config('app.php_date_format')) }}">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="customer2_nationality">{{ __("Nationality") }}:</label>
                                        <input type="text" class="form-control" name="customer2_nationality" id="customer2_nationality" value="{{ old('customer2_nationality') ?? 'ខ្មែរ' }}">
                                    </div>
                                </div>
                                <h5 id="customer-information">{{ __("Contact Information") }}:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="customer_phone_number">C{{ __("Phone Number") }} ({!! __("1st Line") !!}):</label>
                                            <input type="text" name="customer_phone_number" id="customer_phone_number" 
                                                value="{{ old('customer_phone_number') ? old('customer_phone_number') : $unit_deposit_request->customer_phone_number }}"
                                                class="form-control{{ $errors->has('customer_phone_number') ? ' is-invalid' : '' }}">
                                            @if(  $errors->has('customer_phone_number'))
                                            <div class="invalid-feedback">{{ $errors->first('customer_phone_number') }}</div> 
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="customer_phone_number2">{{ __("Phone Number") }} ({!! __("2nd Line") !!})::</label>
                                            <input type="text" class="form-control" name="customer_phone_number2" id="customer_phone_number2" value="{{ old('customer_phone_number2') ? old('customer_phone_number2') : $unit_deposit_request->customer_phone_number2 }}">
                                        </div>
                                    </div>
                                </div>
                                <h5 id="customer-information">{{ __("Address Information") }}:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="customer_address_line1">{{ __("Address Line 1") }}:</label>
                                        <input type="text" name="customer_address_line1" id="customer_address_line1" 
                                               value="{{ old('customer_address_line1') }}"
                                               class="form-control{{ $errors->has('customer_address_line1') ? ' is-invalid' : '' }}">
                                        @if(  $errors->has('customer_address_line1'))
                                        <div class="invalid-feedback">{{ $errors->first('customer_address_line1') }}</div> 
                                        @endif                                          
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="customer_address_line2">{{ __("Address Line 2") }}:</label>
                                        <input type="text" name="customer_address_line2" id="customer_address_line2" 
                                               value="{{ old('customer_address_line2') }}"
                                               class="form-control{{ $errors->has('customer_address_line2') ? ' is-invalid' : '' }}">
                                        @if(  $errors->has('customer_address_line2'))
                                        <div class="invalid-feedback">{{ $errors->first('customer_address_line2') }}</div> 
                                        @endif                                          
                                    </div>                                    
                                </div>                                
                            </div>
                            <div class="tab-pane fade" id="agent" role="tabpanel" aria-labelledby="agent-tab">
                                <h5 id="sale-representative-information">{{ __("Sale Representative Information") }}:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="sale_representative_control">{{ __("Please search for Sale Representative.") }}</label>
                                        <input type="hidden" value="" name="sale_representative_id" />
                                        <select class="form-control" id="sale_representative_search_control">
                                        </select>
                                    </div>                                    
                                </div>
                                <div class="row"> 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sale_representative_name">{{ __("Name") }}:</label>
                                            <input type="text" id="sale_representative_name" class="form-control"
                                                value="" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sale_representative_name_en">{{ __("Name (English)") }}:</label>
                                            <input type="text" id="sale_representative_name_en" class="form-control"
                                                value="" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sale_representative_national_id">{{ __("National ID") }}:</label>
                                            <input type="text" id="sale_representative_national_id" class="form-control"
                                                value="" readonly="readonly" />
                                        </div>
                                    </div>
                                </div>

                                <h5 id="agent-information">{{ __("Agent Information") }}:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="agent_search_control">{{ __("Please search for agent.") }}</label>
                                        <input type="hidden" value="{{ $agent->id }}" name="agent_id" />
                                        <select class="form-control" id="agent_search_control">                                             
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3"> 
                                        <div class="form-group">
                                            <label for="agent_name">{{ __("Agent Name") }}:</label>
                                            <input type="text" id="agent_name" class="form-control"
                                                value="{{ $agent->name }}" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3"> 
                                        <div class="form-group">
                                            <label for="agent_gender">{{ __("Gender") }}:</label>                                          
                                            <input type="text" id="agent_gender" class="form-control" readonly="readonly" 
                                                value="{{ $agent->gender }}"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-3"> 
                                        <div class="form-group">
                                            <label for="agent_phone_number">{{ __("Phone Number") }}:</label>
                                            <input type="text" id="agent_phone_number"  readonly="readonly" 
                                                value="{{ $agent->phone_number }}" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3"> 
                                        <div class="form-group">
                                            <label for="sale_team_leader">{{ __("Sale Team Leader") }}:</label>
                                            <input type="text" id="sale_team_leader"  readonly="readonly" 
                                                value="{{ $manager ? $manager->name : 'N/A' }}" class="form-control" />
                                        </div>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-md-12"> 
                                        <div class="form-group">
                                            <label for="agent_remark">{{ __("Agent Remark") }}:</label>
                                            <textarea class="form-control{{ $errors->has('agent_remark') ? ' is-invalid' : '' }}" name="agent_remark" id="agent_remark" rows="3">{{ $unit_contract_request->remark }}</textarea>
                                        </div>
                                    </div>                            
                                </div>
                                <h5 id="unit-information">{{ __("Unit Information") }}:</h5>
                                <hr class="mt-0">  
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="unit_search_control">{{ __("Please find the unit you want to make contract.") }}</label>
                                        <select class="form-control" id="unit_search_control">                                             
                                        </select>
                                    </div>
                                </div>                             
                                <div class="row">
                                    <div class="col-lg-4 form-group">
                                        <label for="unit_name">{{ __("Unit Code") }}:</label>
                                        <input type="hidden" name="unit_id" value="{{ $unit->id }}"/>
                                        <input type="text" id="unit_code" class="form-control" 
                                            value="{{ $unit->code }}" readonly />
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="unit_price">{{ __("Price") }}:</label>
                                        <input type="text" id="unit_price" class="form-control currency" readonly value="{{ $unit->price }}" />
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="unit_sold_at">{{ __("Unit Sold At") }}:</label>
                                        <input type="text" class="form-control datepicker" name="unit_sold_at" id="unit_sold_at" 
                                            value="{{ $unit_deposit_request->deposited_at->toSystemDateString() }}">
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="sign_date">{{ __("Signed At") }}:</label>
                                        <input type="text" class="form-control datepicker" name="signed_at" id="signed_at"
                                            value="{{ $unit_contract_request->signed_at->toSystemDateString() }}">
                                    </div>
                                </div>
                                <div class="row">                                   
                                    <div class="col-lg form-group">
                                        <label for="street">{{ __("Street") }}:</label>
                                        <input type="text" id="street" 
                                            value="{{ $unit->street }}" class="form-control" readonly />
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="street_corner">{{ __("Street Corner") }}:</label>
                                        <input type="text" id="street_corner" value="{{ $unit->street_corner }}" class="form-control" readonly />
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="street_size">{{ __("Street Size") }}:</label>
                                        <input type="text" id="street_size" 
                                            value="{{ $unit->street_size }}" class="form-control" readonly />
                                    </div>                                    
                                    <div class="col-lg form-group">
                                        <label for="floor">{{ __("Floor") }}:</label>
                                        <input type="text" id="floor" value="{{ $unit->floor }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-lg form-group">
                                        <label for="land_size_width">{{ __("Land Width") }}:</label>
                                        <input type="number" id="land_size_width" value="{{ $unit->land_size_width }}" class="form-control" readonly />
                                    </div>                                   
                                    <div class="col-lg form-group">
                                        <label for="land_size_length">{{ __("Land Length") }}:</label>
                                        <input type="number" id="land_size_length" value="{{ $unit->land_size_length }}" class="form-control" readonly />
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="land_area">{{ __("Land Area") }}:</label>
                                        <input type="number" id="land_area" value="{{ $unit->land_area }}" class="form-control" readonly />
                                    </div>                                 
                                </div>
                                <div class="row">                                    
                                    <div class="col-lg form-group">
                                        <label for="building_size_width">{{ __("House Width") }}:</label>
                                        <input type="number" id="building_size_width" value="{{ $unit->building_size_width }}" class="form-control" readonly />
                                    </div>                                    
                                    <div class="col-lg form-group">
                                        <label for="building_size_length">{{ __("House Length") }}:</label>
                                        <input type="number" id="building_size_length" value="{{ $unit->building_size_length }}" class="form-control" readonly />
                                    </div>                                   
                                    <div class="col-lg form-group">
                                        <label for="building_area">{{ __("House Area") }}:</label>
                                        <input type="number" id="building_area" value="{{ $unit->building_area }}" class="form-control" readonly />
                                    </div>                                    
                                </div>
                                <div class="form-group row">
                                    <label for="gross_area" class="col-lg-8 col-form-label text-lg-right">If unit is condo, this value is stated as gross area:</label>
                                    <div class="col-lg-4 form-group">                                     
                                        <input type="number" id="gross_area" value="{{ $unit->gross_area }}" class="form-control" readonly />
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="living_room">{{ __("Living Room") }}:</label>
                                        <input type="text" id="living_room" class="form-control" value="{{ $unit->living_room }}" readonly />
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="kitchen">{{ __("Kitchen") }}:</label>
                                        <input type="text" id="kitchen" class="form-control" value="{{ $unit->kitchen }}" readonly />
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="bedroom">{{ ("Bedroom") }}:</label>
                                        <input type="text" id="bedroom" class="form-control" value="{{ $unit->bedroom }}" readonly />
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="bathroom">{{ __("Bathroom") }}</label>
                                        <input type="text" id="bathroom" class="form-control" value="{{ $unit->bathroom }}" readonly />
                                    </div>
                                </div> 

                                <h5 id="customer-information">{{ __("Unit Type Information") }}:</h5>                                
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg-4 form-group">
                                        <label for="unit_type">{{ __("Unit Type") }}:</label>
                                        <input type="text" name="unit_type_name" id="unit_type_name" class="form-control" 
                                            value="{{ $unit->unitType->name }}" readonly="readonly" />
                                    </div>   
                                    <div class="col-lg form-group">
                                        <label for="annual_management_fee">{{ __("Annual Management Fee") }}:</label>
                                        <input type="text" name="annual_management_fee" id="annual_management_fee" class="form-control"
                                            value="{{ old('annual_management_fee') ?? $unit->unitType->annual_management_fee }}" />
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="contract_transfer_fee">{{ __("Contract Transfer") }}:</label>
                                        <input type="text" name="contract_transfer_fee" id="contract_transfer_fee" class="form-control" 
                                        value="{{ old('contract_transfer_fee') ?? $unit->unitType->contract_transfer_fee }}" />
                                    </div>                                
                                    <div class="col-lg form-group">
                                        <label for="management_fee_per_square">{{ __("Management Fee Per Sqm") }}:</label>
                                        <input type="text" name="management_fee_per_square" id="management_fee_per_square" class="form-control" 
                                        value="{{ old('management_fee_per_square') ?? $unit->unitType->management_fee_per_square }}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="deadline">{{ __("Deadline") }}:</label>
                                        <input type="text" name="deadline" id="deadline" class="form-control"
                                        value="{{ old('deadline') ?? $unit->unitType->deadline }}" />
                                    </div>
                                     <div class="col-lg form-group">
                                        <label for="extended_deadline">{{ __("Extended Deadline") }}:</label>
                                        <input type="text" name="extended_deadline" id="extended_deadline" class="form-control"
                                        value="{{ old('extended_deadline') ?? $unit->unitType->extended_deadline }}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="title_clause_kh">{{ __("Title Clause") }}:</label>
                                        <textarea class="form-control" rows="4" name="title_clause_kh" id="title_clause_kh">{{ old('title_clause_kh') ?? $unit->unitType->title_clause_kh }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="">{{ __("Management Service Clause") }}:</label>
                                        <textarea class="form-control" rows="4" name="management_service_kh" id="management_service_kh">{{ old('management_service_kh') ?? $unit->unitType->management_service_kh}}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="">{{ __("Equipment Clause") }}:</label>
                                        <textarea class="form-control" name="equipment_text" id="equipment_text" rows="4">{{ old('equipment_text') ?? $unit->unitType->equipment_text}}</textarea>
                                    </div>
                                </div>             
                            </div>                           
                            <div class="tab-pane fade" id="discount-payment" role="tabpanel" aria-labelledby="discount-payment-tab">
                                <div class="row">
                                    <div class="col-md-5">
                                        <h5>{{ __("Payment Information") }}</h5>
                                        <hr class="mt-0">
                                        <table class="table-couple">
                                            <tr>
                                                <td class="title" width="210px">{{ __("Unit Sale Price") }}:</td>    
                                                <td class="p-0">                                                    
                                                    <input type="text" class="form-control" name="unit_sale_price" value="{{ $unit_deposit_request->unit_sale_price }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Discount Promotion") }}:</td>         
                                                <td class="p-0">                                                    
                                                    <input type="text" min="0" class="form-control changable-price" name="discount_promotion" value="{{ $unit_deposit_request->discount_promotion }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Other Discount Allowed") }}:</td>
                                                <td class="p-0">                                                    
                                                    <input type="text" class="form-control" name="other_discount_allowed" value="{{ $unit_deposit_request->other_discount_allowance }}" />
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Price After Discount") }}:</td>
                                                <td class="text bg-grey"><span class="currency" id="price_after_discount"></span></td>
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Discount Payment Option $") }}:</td>
                                                <td class="text bg-grey"><span class="currency" id="discount_payment_option"></span></td>
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Property Final Price") }}:</td>
                                                <td class="text bg-grey"><span class="currency" id="final_price"></span></td>
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Deposited Amount") }}:</td>
                                                <td class="p-0">                                                    
                                                    <input type="text" class="form-control" name="deposited_amount" value="{{ $unit_deposit_request->deposit_amount }}" />
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="title">{{ __("Deposited At") }}:</td>
                                                <td class="p-0">                                                    
                                                    <input type="text" class="form-control datepicker" name="deposited_at" value="{{ $unit_deposit_request->deposited_at->toSystemDateString() }}" >
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <td class="title">{{ __("Start Payment Date") }}:</td>
                                                <td class="p-0">                                                    
                                                    <input type="text" class="form-control datepicker" name="start_payment_date" value="{{ $unit_contract_request->start_payment_date->toSystemDateString() }}">
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Start Payment No") }}:</td>
                                                <td class="p-0">                                                    
                                                    <input type="number" min="0" class="form-control" name="start_payment_number" value="{{old('start_payment_number') ? old('start_payment_number') : 0 }}">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-7">
                                        <h5>{{ __("Payment Option") }}</h5>
                                        <hr class="mt-0">
                                        <table class="table-couple mb-3"> 
                                            <tr>
                                                <td class="title" width="220px">{{ __("Selected Payment Option") }}:</td>
                                                <td class="p-0">                             
                                                    <input type="hidden" name="payment_option_id" value="{{ $payment_option_array['id'] }}"/>
                                                    <select class="form-control" id="payment_option">
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table-couple mb-3"> 
                                            <tr>
                                                <td class="title" width="220px">{{ __("Has First Payment?") }}:</td>
                                                <td class="p-0">
                                                    <select class="form-control" name="is_first_payment" id="is_first_payment" disabled="disabled">
                                                        <option value="0" {{ $payment_option_array['is_first_payment'] == false ? 'selected' : '' }}>No</option>
                                                        <option value="1" {{ $payment_option_array['is_first_payment'] == true  ? 'selected' : '' }}>Yes</option>
                                                    </select>
                                                </td>
                                            </tr>                                            
                                            <tr class="collapse first_payment_field {{ $payment_option_array['is_first_payment'] == true ? 'show' : '' }}">
                                                <td class="title">{{ __("First Payment Duration") }}:</td>
                                                <td class="p-0">
                                                    <input type="number" min="0" class="form-control" name="first_payment_duration" id="first_payment_duration" readonly="readonly" value="{{ $payment_option_array['first_payment_duration'] }}">
                                                </td>                                                
                                            </tr>                                   
                                            <tr class="collapse first_payment_field {{ $payment_option_array['is_first_payment'] == true ? 'show' : '' }}">
                                                <td class="title p-0">
                                                    <select class="form-control" id="first_payment_option" >
                                                        <option value="1" {{ $payment_option_array['first_payment_percentage'] > 0 ? 'selected' : '' }}>{{ __("First Payment Percentage") }}</option>
                                                        <option value="2" {{ $payment_option_array['first_payment_amount'] > 0 ? 'selected' : '' }}>{{ __("First Payment Amount") }}</option>
                                                    </select>
                                                </td>
                                                <td class="p-0">
                                                    <input type="number" min="0" max="100" class="form-control d-none" name="first_payment_percentage" id="first_payment_percentage" value="{{ $payment_option_array['first_payment_percentage'] }}" readonly="readonly">
                                                    <input type="number" min="0" class="form-control" name="first_payment_amount" id="first_payment_amount" value="{{ $payment_option_array['first_payment_amount']  }}" readonly="readonly">
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table-couple"> 
                                            <tr>
                                                <td class="title" width="220px">{{ __("Loan Duration") }}:</td>   
                                                <td class="p-0">
                                                    <input type="number" min="1" class="form-control" name="loan_duration" id="loan_duration" value="{{ $payment_option_array['loan_duration'] }}" readonly="readonly">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Interest Rate") }}:</td>
                                                <td class="p-0">
                                                    <input type="number" min="0" max="100" class="form-control" name="interest" id="interest" value="{{ $payment_option_array['interest'] }}" readonly="readonly">
                                                </td>
                                            </tr>                                  
                                            <tr>
                                                <td class="title">{{ __("Discount Payment Option %") }}:</td>
                                                <td class="p-0">
                                                    <input type="number" min="0" max="100" class="form-control changable-price" name="special_discount" id="special_discount" value="{{ $payment_option_array['special_discount'] }}" readonly="readonly">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Rouding Result") }}:</td>
                                                <td class="p-0">
                                                    <select class="form-control" name="loan_result_rounding" id="loan_result_rounding">
                                                        <option value="0" {{ old('loan_result_rounding') == 0 ? '' : 'selected' }}>No</option>
                                                        <option value="1" {{ old('loan_result_rounding') == 0 ? 'selected' : '' }}>Yes</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-auto py-3">
                                        <button type="button" class="btn btn-primary" id="btn-show-loan">{{ __("Show Schedule") }}</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h5>{{ __("Installment Plan") }}</h5>
                                        <hr class="mt-0">                                        
                                        <table class="table table-bordered" id="first_payment_table">
                                            <thead>
                                                <tr class="bg-grey">
                                                    <th colspan="6" class="text-center">{{ __("Down Payment Plan") }}</th>
                                                </tr>
                                                <tr class="bg-grey">
                                                    <th>{{ __("No") }}</th>
                                                    <th>{{ __("Payment Date") }}</th>
                                                    <th>{{ __("Beginning Balance") }}</th>
                                                    <th>{{ __("Payment Amount") }}</th>
                                                    <th>{{ __("Ending Balance") }}</th>
                                                    <th>{{ __("Note") }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                               
                                            </tbody>
                                        </table>                                      
                                        <table class="table table-bordered" id="payment_schedule_table">
                                            <thead>
                                                <tr class="bg-grey">
                                                    <th colspan="7" class="text-center">{{ __("Installment Plan") }}</th>
                                                </tr>
                                                <tr class="bg-grey">
                                                    <th>{{ __("No") }}</th>
                                                    <th>{{ __("Payment Date") }}</th>
                                                    <th>{{ __("Beginning Balance") }}</th>
                                                    <th>{{ __("Payment Amount") }}</th>
                                                    <th>{{ __("Principal") }}</th>
                                                    <th>{{ __("Interest") }}</th>
                                                    <th>{{ __("Ending Balance") }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                              
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                @if($errors->has('attachments'))
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first('attachments') }}
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer1_id_front">{{ __("Customer 1 ID front") }}:</label>    
                                            <input type="file" name="attachments[customer1_id_front]" id="customer1_id_front" class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer1_id_back">{{ __("Customer 1 ID back") }}:</label> 
                                            <input type="file" name="attachments[customer1_id_back]" id="customer1_id_back" class="form-control-file">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer2_id_front">{{ __("Customer 2 ID front") }}:</label>    
                                            <input type="file" name="attachments[customer2_id_front]" id="customer2_id_front" class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer2_id_back">{{ __("Customer 2 ID back") }}:</label> 
                                            <input type="file" name="attachments[customer2_id_back]" id="customer2_id_back" class="form-control-file">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer1_passport_image">{{ __("Customer 1 Passport") }}:</label>    
                                            <input type="file" name="attachments[customer1_passort]" id="customer1_passport_image" class="form-control-file">
                                        </div>
                                    </div>                                 
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer2_passort">{{ __("Customer 2 Passport") }}:</label>    
                                            <input type="file" name="attachments[customer2_passort]" id="customer2_passort" class="form-control-file">
                                        </div>
                                    </div>                                 
                                </div>                               
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-secondary tab-nav-pre mr-1 d-none">{{__("Back")}}</button>
                                <button type="button" class="btn btn-secondary mr-1 tab-nav-next">{{__("Next")}}</button>
                                <button type="submit" class="btn btn-primary d-none" value="validate">{{__("Create New")}} {{ __("Contract") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.unit_contract_requests.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Contract") }} {{__("List")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script type="text/javascript">  
   
    $(document).ready(function () {

        $('.nav-tabs .nav-item a').click(function (){
            $('.tab-nav-next').addClass('d-none');
            $('.tab-nav-pre').addClass('d-none');
            $("button[type='submit']").addClass('d-none');         
            if ( $(this).parent().prev("li")[0] == undefined ) {
                $('.tab-nav-next').removeClass('d-none');                
            }        
            if ( $(this).parent().prev("li")[0] != undefined &&  $(this).parent().next("li")[0] != undefined) {
                $('.tab-nav-next').removeClass('d-none');
                $('.tab-nav-pre').removeClass('d-none');
            }     
            if (  $(this).parent().next("li")[0] == undefined ) {
                $("button[type='submit']").removeClass('d-none');
                $('.tab-nav-pre').removeClass('d-none');
                $('.tab-nav-next').addClass('d-none');
            }      
        });

        $('.tab-nav-next').click(function() {
            $('.nav-tabs .active').parent().next('li').find('a').trigger('click');
            if ( $('.nav-tabs .active').parent().prev('li')[0] != undefined ) {
                $(".tab-nav-pre").removeClass('d-none');
            }
            if ( $('.nav-tabs .active').parent().next('li')[0] == undefined ) {
                $("button[type='submit']").removeClass('d-none');                
                $(this).addClass('d-none');
            }
        });

        $('.tab-nav-pre').click(function() {
            $('.nav-tabs .active').parent().prev('li').find('a').trigger('click');  
            if ( $('.nav-tabs .active').parent().next('li')[0] != undefined ) {
                $(".tab-nav-next").removeClass('d-none');
                $(this).removeClass('d-none');
                $("button[type='submit']").addClass('d-none'); 
            }
            if ( $('.nav-tabs .active').parent().prev('li')[0] == undefined ) {                               
                $(this).addClass('d-none');
            }
        });
    });
</script>    
@endpush
