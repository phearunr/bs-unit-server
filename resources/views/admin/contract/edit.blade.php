@extends('layouts.app')

@section('styles')
<style type="text/css">
    .thumbnail-lg {
        width: 360px !important;        
    }
    .thumbnial-delete-btn {
        position: absolute;
        top: -15px;
        right: -13px;
        padding: 4px 4px 0px 4px;
        line-height: 1.2rem;
    }
    .thumbnial-delete-btn i {
        font-size: 1.2rem;
    }
</style>
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.contracts.update', ['id'=> $contract->id]) }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data" id="create-contract-form">
        @csrf
        {{ method_field('PUT') }}      
        <div class="row justify-content-center">
            @includeWhen($contract->status == App\Helpers\ContractStatus::CANCELLED, 'admin.contract.partial.cancelled')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">{{__("Edit")}} {{ __("Contract") }}</div>
                    <div class="card-body p-0">  
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif 
                        @if ($errors->any())                            
                            @if ( $errors->has('contract') )
                                <div class="alert alert-danger mb-0" role="alert">
                                    {{ $errors->first('contract') }}
                                </div>
                            @else
                                <div class="alert alert-danger mb-0" role="alert">
                                There are some data which is not match the system's requirement, please check again.
                            </div>
                            @endif                            
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
                                            value="{{ old('customer1_name') ? old('customer1_name') : $contract->customer1_name }}"
                                            class="form-control{{ $errors->has('customer1_name') ? ' is-invalid' : '' }}">
                                        @if(  $errors->has('customer1_name'))
                                        <div class="invalid-feedback">{{ $errors->first('customer1_name') }}</div> 
                                        @endif 
                                    </div>                            
                                    <div class="col-lg-3 form-group">
                                        <label for="customer1_gender">{{ __("Gender") }}:</label>
                                        <select class="form-control" name="customer1_gender" id="customer1_gender">
                                            <option value="1" {{ $contract->customer1_gender == 1 ? 'selected' : '' }}>Male</option>
                                            <option value="2" {{ $contract->customer1_gender == 2 ? 'selected' : '' }}>Female</option>
                                        </select>                                            
                                    </div>                               
                                    <div class="col-lg-3 form-group">
                                        <label for="customer1_birthdate">{{ __("Date of Birth") }}:</label>
                                        <input type="text" class="form-control datepicker" name="customer1_birthdate" id="customer1_birthdate" 
                                            value="{{ old('customer1_birthdate') ? old('customer1_birthdate') : (is_null($contract->customer1_birthdate) ? date(config('app.php_date_format')) : $contract->customer1_birthdate->toSystemDateString()) }}">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="customer1_nid">{{ __("Identity Number") }}:</label>
                                        <input type="text" name="customer1_nid" id="customer1_nid" 
                                            value="{{ old('customer1_nid') ?? $contract->customer1_nid }}"
                                            class="form-control{{ $errors->has('customer1_nid') ? ' is-invalid' : '' }}" >
                                        @if(  $errors->has('customer1_nid'))
                                        <div class="invalid-feedback">{{ $errors->first('customer1_nid') }}</div> 
                                        @endif 
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="customer1_nid_issued_date">{{ __("ID Issued Date") }}:</label>
                                        <input type="text" class="form-control datepicker" name="customer1_nid_issued_date" id="customer1_nid_issued_date" value="{{ is_null($contract->customer1_nid_issued_date) ? date('Y-m-d') : $contract->customer1_nid_issued_date->toSystemDateString() }}">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="customer1_nationality">{{ __("Nationality") }}:</label>
                                        <input type="text" name="customer1_nationality" id="customer1_nationality" 
                                            value="{{ old('customer1_nationality') ?? $contract->customer1_nationality }}"
                                            class="form-control{{ $errors->has('customer1_nationality') ? ' is-invalid' : '' }}" >
                                        @if(  $errors->has('customer1_nationality'))
                                        <div class="invalid-feedback">{{ $errors->first('customer1_nationality') }}</div> 
                                        @endif 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check pb-2">
                                            <input type="checkbox" class="form-check-input" id="second_customer" {{ old("customer2_name") ? 'checked' : $contract->customer2_name ? 'checked' : '' }}>
                                            <label class="form-check-label text-primary" for="second_customer">{{__("This contract will contain 2 customers")}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row collapse" id="second_customer_container">                                     
                                    <div class="col-lg-6 form-group">
                                        <label for="customer1_name">{{ __("Customer (2) name") }}:</label>
                                        <input type="text" class="form-control" name="customer2_name"  id="customer2_name" value="{{ $contract->customer2_name }}">
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <label for="customer2_gender">{{ __("Gender") }}:</label>
                                        <select class="form-control" name="customer2_gender" id="customer2_gender">
                                            <option value="1" {{ $contract->customer2_gender == 1 ? 'selected' : '' }}>Male</option>
                                            <option value="2" {{ $contract->customer2_gender == 2 ? 'selected' : '' }}>Female</option>
                                        </select>  
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <label for="customer2_birthdate">{{ __("Date of Birth") }}:</label>
                                        <input type="text" class="form-control datepicker" name="customer2_birthdate" id="customer2_birthdate" value="{{ is_null($contract->customer2_birthdate) ? date('Y-m-d') : $contract->customer2_birthdate->toSystemDateString() }}">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="customer2_nid">{{ __("Identity Number") }}:</label>
                                        <input type="text" class="form-control" name="customer2_nid" id="customer2_nid" value="{{ old('customer2_nationality') ?? $contract->customer2_nid }}">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="customer2_nid_issued_date">{{ __("ID Issued Date") }}:</label>
                                        <input type="text" class="form-control datepicker" name="customer2_nid_issued_date" id="customer2_nid_issued_date" value="{{ is_null($contract->customer2_nid_issued_date) ? date(config('app.php_date_format')) : $contract->customer2_nid_issued_date->toSystemDateString() }}">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="customer2_nationality">{{ __("Nationality") }}:</label>
                                        <input type="text" class="form-control" name="customer2_nationality" id="customer2_nationality" value="{{ old('customer2_nationality') ?? $contract->customer2_nationality }}">
                                    </div>
                                </div>
                                <h5 id="customer-information">{{ __("Contact Information") }}:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="customer_phone_number">{{ __("Phone Number") }} ({!! __("1st Line") !!}):</label>
                                            <input type="text" name="customer_phone_number" id="customer_phone_number" 
                                                value="{{ old('customer_phone_number') ? old('customer_phone_number') : $contract->customer_phone_number }}"
                                                class="form-control{{ $errors->has('customer_phone_number') ? ' is-invalid' : '' }}">
                                            @if(  $errors->has('customer_phone_number'))
                                            <div class="invalid-feedback">{{ $errors->first('customer_phone_number') }}</div> 
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="customer_phone_number2">{{ __("Phone Number") }} ({!! __("2nd Line") !!}):</label>
                                            <input type="text" class="form-control" name="customer_phone_number2" id="customer_phone_number2" value="{{ $contract->customer_phone_number2 }}">
                                        </div>
                                    </div>
                                </div>
                                <h5 id="customer-information">{{ __("Address Information") }}:</h5>
                                <hr class="mt-0">                                
                                <div class="row">                                 
                                    <div class="col-lg form-group">
                                        <label for="customer_address_line1">{{ __("Address Line 1") }}:</label>
                                        <input type="text" name="customer_address_line1" id="customer_address_line1" 
                                               value="{{ old('customer_address_line1') ? old('customer_address_line1') : $contract->customer_address_line1 }}"
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
                                               value="{{ old('customer_address_line2') ? old('customer_address_line2') : $contract->customer_address_line2 }}"
                                               class="form-control{{ $errors->has('customer_address_line2') ? ' is-invalid' : '' }}">
                                        @if(  $errors->has('customer_address_line2'))
                                        <div class="invalid-feedback">{{ $errors->first('customer_address_line2') }}</div> 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="agent" role="tabpanel" aria-labelledby="agent-tab">
                                <h5 id="sale-representative-information">{{ __("Sale Representative Information") }} {{ $sale_representative->id }}:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="sale_representative_control">{{ __("Please search for Sale Representative.") }}</label>
                                        <input type="hidden" value="{{ $sale_representative->id }}" name="sale_representative_id" />
                                        <select class="form-control" id="sale_representative_search_control"></select>
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
                                                value="{{ $sale_representative->name_en }}" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sale_representative_national_id">{{ __("National ID") }}:</label>
                                            <input type="text" id="sale_representative_national_id" class="form-control"
                                                value="{{ $sale_representative->national_id }}" readonly="readonly" />
                                        </div>
                                    </div>
                                </div>

                                <h5 id="customer-information">{{ __("Agent Information") }}:</h5>
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
                                    <div class="col-lg-4"> 
                                        <div class="form-group">
                                            <label for="agent_name">{{ __("Agent Name") }}:</label>
                                            <input type="text" id="agent_name" class="form-control"
                                                value="{{ $agent->name }}" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4"> 
                                        <div class="form-group">
                                            <label for="agent_gender">{{ __("Gender") }}:</label>                                          
                                            <input type="text" id="agent_gender" class="form-control" readonly="readonly" 
                                                value="{{ $agent->gender }}"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4"> 
                                        <div class="form-group">
                                            <label for="agent_phone_number">{{ __("Phone Number") }}:</label>
                                            <input type="text" id="agent_phone_number"  readonly="readonly" 
                                                value="{{ $agent->phone_number }}" class="form-control" />
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-12"> 
                                        <div class="form-group">
                                            <label for="agent_remark">{{ __("Agent Remark") }}:</label>
                                            <textarea class="form-control{{ $errors->has('agent_remark') ? ' is-invalid' : '' }}"  id="agent_remark" name="agent_remark" rows="3">{{ old('agent_remark') ? old('agent_remark') : $contract->agent_remark }}</textarea>
                                            @if(  $errors->has('agent_remark'))
                                            <div class="invalid-feedback">{{ $errors->first('agent_remark') }}</div> 
                                            @endif  
                                        </div>
                                    </div>                            
                                </div>
                                <h5 id="customer-information">{{ __("Unit Information") }}:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="unit_search_control">{{ __("Please find the unit you want to make contract.") }}:</label>
                                        <select class="form-control" id="unit_search_control">                                             
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4"> 
                                        <div class="form-group">
                                            <label for="unit_code">{{ __("Unit Code") }}:</label>
                                            <input type="hidden" name="unit_id" value="{{ $contract->unit_id }}" />
                                            <input type="text" id="unit_code" class="form-control" value="" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="unit_price">{{ __("Price") }}:</label>
                                            <input type="text" min="0" id="unit_price" 
                                                value="{{ $unit->price }}"
                                                class="form-control currency" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="unit_sold_at">{{ __("Unit Sold At") }}:</label>
                                            <input type="text" class="form-control datepicker" name="unit_sold_at" id="unit_sold_at" 
                                                value="{{ old('unit_sold_at') ? old('unit_sold_at') : (is_null($contract->unit_sold_at) ? date(config('app.php_date_format')) : $contract->unit_sold_at->toSystemDateString()) }}"
                                                class="form-control datepicker">
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="signed_at">{{ __("Signed At") }}:</label>
                                            <input type="text" class="form-control datepicker" name="signed_at" id="signed_at" 
                                                value="{{ old('signed_at') ? old('signed_at') : (is_null($contract->signed_at) ? date(config('app.php_date_format')) : $contract->signed_at->toSystemDateString()) }}"
                                                class="form-control datepicker">
                                        </div>
                                    </div>                                                                      
                                </div>
                                <div class="row">
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="street">{{ __("Street") }}:</label>
                                            <input type="text" id="street" value="" class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="street_corner">{{ __("Street Corner") }}:</label>
                                            <input type="text" id="street_corner" value="" class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="street_size">{{ __("Street Size") }}:</label>
                                            <input type="text" id="street_size" 
                                                value="" class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="floor">{{ __("Floor") }}:</label>
                                        <input type="text" id="floor" value="" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="land_size_width">{{ __("Land Width") }}:</label>
                                            <input type="number" id="land_size_width" value="" class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="land_size_length">{{ __("Land Length") }}:</label>
                                            <input type="number" id="land_size_length" value="" class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="land_area">{{ __("Land Area") }}:</label>
                                            <input type="number" id="land_area" value="" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="building_size_width">{{ __("House Width") }}:</label>
                                            <input type="number" id="building_size_width" value="" class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="building_size_length">{{ __("House Length") }}:</label>
                                            <input type="number" id="building_size_length" value="" class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="building_area">{{ __("House Area") }}:</label>
                                            <input type="number" id="building_area" value="" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gross_area" class="col-lg-8 col-form-label text-lg-right">If unit is condo, this value is stated as gross area:</label>
                                    <div class="col-lg-4 form-group">                                     
                                        <input type="number" id="gross_area" value="" class="form-control" readonly />
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="living_room">{{ __("Living Room") }}:</label>
                                        <input type="text" id="living_room" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="kitchen">{{ __("Kitchen") }}:</label>
                                        <input type="text" id="kitchen" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="bedroom">{{ ("Bedroom") }}:</label>
                                        <input type="text" id="bedroom" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="bathroom">{{ __("Bathroom") }}:</label>
                                        <input type="text" id="bathroom" class="form-control" value="" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <small id="passwordHelpBlock" class="form-text text-muted">
                                                For unit measurement, you need to input as english number, so that the system can calculate and format it to Khmer Unicode Number.
                                            </small>
                                        </div>
                                    </div> 
                                </div>
                                <h5 id="unit-information">{{ __("Unit Type Information") }}:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg-4"> 
                                        <div class="form-group">
                                            <label for="unit_type">{{ __("Unit Type") }}</label>
                                            <input type="text" name="unit_type_name" id="unit_type_name" class="form-control" value="{{ $unit->unitType->name }}" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="annual_management_fee">{{ __("Annual Management Fee") }}:</label>
                                            <input type="text" min="0" name="annual_management_fee" id="annual_management_fee" 
                                                value="{{ old('annual_management_fee') ?? $contract->annual_management_fee }}"
                                                class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="contract_transfer_fee">{{ __("Contract Transfer") }}:</label>
                                            <input type="text" min="0" name="contract_transfer_fee" id="contract_transfer_fee" 
                                                value="{{ old('contract_transfer_fee') ?? $contract->contract_transfer_fee }}" 
                                                class="form-control" />                                           
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="management_fee_per_square">{{ __("Management Fee Per Sqm") }}:</label>
                                            <input type="text" min="0" name="management_fee_per_square" id="management_fee_per_square" 
                                                value="{{ old('management_fee_per_square') ?? $contract->management_fee_per_square }}" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="deadline">{{ __("Deadline") }}:</label>
                                        <input type="text" name="deadline" id="deadline" class="form-control" value="{{ $contract->deadline }}">
                                    </div>
                                     <div class="col-lg form-group">
                                        <label for="extended_deadline">{{ __("Extended Deadline") }}:</label>
                                        <input type="text" name="extended_deadline" id="extended_deadline" class="form-control" 
                                               value="{{ old('extended_deadline') ?? $contract->extended_deadline }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="title_clause_kh">{{ __("Title Clause") }}:</label>
                                        <textarea class="form-control" rows="4" name="title_clause_kh" id="title_clause_kh">{{ old('title_clause_kh') ?? $contract->title_clause_kh }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="management_service_kh">{{ __("Management Service Clause") }}:</label>
                                        <textarea class="form-control" rows="4" name="management_service_kh" id="management_service_kh">{{ old('management_service_kh') ?? $contract->management_service_kh }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="">{{ __("Equipment Clause") }}:</label>
                                        <textarea class="form-control" name="equipment_text" id="equipment_text" rows="4">{{ old('equipment_text') ?? $contract->equipment_text }}</textarea>
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
                                                    <input type="text" class="form-control changable-price" name="unit_sale_price" value="{{ $contract->unit_sale_price}} ">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Discount Promotion") }}:</td>
                                                <td class="p-0">                                                    
                                                    <input type="text" min="0" class="form-control changable-price" name="discount_promotion" value="{{$contract->discount_promotion}}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Other Discount Allowed") }}:</td>
                                                <td class="p-0">                                                    
                                                    <input type="text" class="form-control changable-price" name="other_discount_allowed" value="{{$contract->other_discount_allowed}}">
                                                </td>                                                
                                            <tr>
                                                <td class="title">{{ __("Price After Discount") }}:</td>
                                                <td class="text bg-grey"><span class="currency" id="price_after_discount">{{ $contract->getUnitSoldPriceAfterDiscount() }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Discount Payment Option $") }}:</td>
                                                <td class="text bg-grey"><span class="currency" id="discount_payment_option">{{ $contract->getDiscountAmountByPaymentOption() }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Property Final Price") }}:</td>
                                                <td class="text bg-grey"><span class="currency" id="final_price">{{ $contract->getUnitSoldPriceAfterAllDiscount() }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Deposited Amount") }}:</td>
                                                <td class="p-0">                                                    
                                                    <input type="text" class="form-control" name="deposited_amount" value="{{$contract->deposited_amount}}">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="title">{{ __("Deposited At") }}:</td>
                                                <td class="p-0">                                                    
                                                    <input type="text" class="form-control datepicker" name="deposited_at" value="{{$contract->deposited_at->toSystemDateString()}}">
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <td class="title">{{ __("Start Payment Date") }}:</td>
                                                <td class="p-0">     
                                                    <input type="text" class="form-control datepicker" name="start_payment_date" value="{{$contract->start_payment_date->toSystemDateString()}}">
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Start Payment No") }}:</td>
                                                <td class="p-0">                                                    
                                                    <input type="number" min="0" class="form-control" name="start_payment_number" value="{{$contract->start_payment_number}}">
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
                                                    <input type="hidden" name="payment_option_id" value="{{ old('payment_option_id') ?? $contract->payment_option_id }}" />
                                                    <select class="form-control" id="payment_option">
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table-couple mb-3">
                                            <tr>
                                                <td class="title" width="220px">{{ __("Has First Payment?") }}:</td>
                                                <td class="p-0">
                                                    <select class="form-control" name="is_first_payment" id="is_first_payment">
                                                        <option value="0" selected="{{ $contract->is_first_payment ? '' : 'selected' }}">No</option>
                                                        <option value="1" selected="{{ $contract->is_first_payment ? 'selected' : '' }}">Yes</option>
                                                    </select>
                                                </td>
                                            </tr>                                            
                                            <tr class="collapse first_payment_field {{ $contract->is_first_payment ? 'show' : '' }}">
                                                <td class="title">{{ __("First Payment Duration") }}:</td>
                                                <td class="p-0">
                                                    <input type="number" min="0" class="form-control" name="first_payment_duration" id="first_payment_duration" value="{{ $contract->first_payment_duration }}">
                                                </td>                                                
                                            </tr>                                   
                                            <tr class="collapse first_payment_field {{ $contract->is_first_payment ? 'show' : '' }}">
                                                <td class="title p-0">
                                                    <select class="form-control" id="first_payment_option" >
                                                        <option value="1" {{ is_null($contract->first_payment_percentage) || $contract->first_payment_percentage == 0 ? '' : 'selected' }}>{{ __("First Payment Percentage") }}</option>
                                                        <option value="2" {{ is_null($contract->first_payment_amount) || $contract->first_payment_amount == 0 ? '' : 'selected' }}>{{ __("First Payment Amount") }}</option>
                                                    </select>                                                    
                                                </td>
                                                <td class="p-0">
                                                    <input type="number" min="0" max="100" 
                                                            class="form-control {{ is_null($contract->first_payment_percentage) ? 'd-none' : '' }}" 
                                                            name="first_payment_percentage" 
                                                            id="first_payment_percentage" 
                                                            value="{{ $contract->first_payment_percentage }}"
                                                    >
                                                    <input type="number" min="0" 
                                                            class="form-control {{ is_null($contract->first_payment_amount) ? 'd-none' : '' }}" 
                                                            name="first_payment_amount" 
                                                            id="first_payment_amount" 
                                                            value="{{ $contract->first_payment_amount }}"
                                                    >
                                                </td>                                                
                                            </tr>
                                        </table>
                                        <table class="table-couple">
                                            <tr>
                                                <td class="title" width="220px">{{ __("Loan Duration") }}:</td>   
                                                <td class="p-0">
                                                    <input type="number" min="1" class="form-control" name="loan_duration" id="loan_duration" value="{{ $contract->loan_duration }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title">{{ __("Interest Rate") }}:</td>
                                                <td class="p-0">
                                                    <input type="number" min="0" max="100" class="form-control" name="interest" id="interest" value="{{ $contract->interest }}">
                                                </td>
                                            </tr>                                  
                                            <tr>
                                                <td class="title">{{ __("Discount Payment Option %") }}:</td>
                                                <td class="p-0">
                                                    <input type="number" min="0" max="100" class="form-control changable-price" name="special_discount" id="special_discount" value="{{ $contract->special_discount }}">
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <td class="title">{{ __("Rouding Result") }}:</td>
                                                <td class="p-0">
                                                    <select class="form-control" name="loan_result_rounding" id="loan_result_rounding">
                                                        <option value="0" {{ $contract->loan_result_rounding ? '' : 'selected' }}>No</option>
                                                        <option value="1" {{ $contract->loan_result_rounding ? 'selected' : '' }}>Yes</option>
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
                                            <label for="customer1_id_front">{{ __("Customer 1 ID front:") }}</label>    
                                            <input type="file" name="attachments[customer1_id_front]" id="customer1_id_front" class="form-control-file">
                                        </div>
                                        @if( isset($attachments['customer1_id_front']) )
                                        <figure class="figure position-relative">
                                            <a href="" target="_blank">
                                                <img src="{{$attachments['customer1_id_front']['path']}}" class="figure-img img-fluid rounded">
                                            </a>
                                            <button class="btn btn-danger btn-xs thumbnial-delete-btn" data-attachment-id="{{ $attachments['customer1_id_front']['id'] }}"> 
                                                <i class="fas fa-trash-alt" data-toggle="tooltip"  data-placement="top" title="{{ __('Remove') }}" data-original-title="{{ __('Remove') }}"></i>
                                            </button>
                                        </figure>
                                        @endif
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer1_id_back">{{ __("Customer 1 ID back") }}:</label> 
                                            <input type="file" name="attachments[customer1_id_back]" id="customer1_id_back" class="form-control-file">
                                        </div>
                                        @if( isset($attachments['customer1_id_back']) )
                                        <figure class="figure position-relative">
                                            <a href="" target="_blank">
                                                <img src="{{$attachments['customer1_id_back']['path']}}" class="figure-img img-fluid rounded">
                                            </a>
                                             <button class="btn btn-danger btn-xs thumbnial-delete-btn" data-attachment-id="{{ $attachments['customer1_id_back']['id'] }}"> 
                                                <i class="fas fa-trash-alt" data-toggle="tooltip"  data-placement="top" title="{{ __('Remove') }}" data-original-title="{{ __('Remove') }}"></i>
                                            </button>
                                        </figure>
                                        @endif
                                    </div>                                    
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer2_id_front">{{ __("Customer 2 ID front") }}:</label>    
                                            <input type="file" name="attachments[customer2_id_front]" id="customer2_id_front" class="form-control-file">
                                        </div>
                                        @if( isset($attachments['customer2_id_front']) )
                                        <figure class="figure position-relative">
                                            <a href="" target="_blank">
                                                <img src="{{$attachments['customer2_id_front']['path']}}" class="figure-img img-fluid rounded">
                                            </a>
                                            <button class="btn btn-danger btn-xs thumbnial-delete-btn" data-attachment-id="{{ $attachments['customer2_id_front']['id'] }}"> 
                                                <i class="fas fa-trash-alt" data-toggle="tooltip"  data-placement="top" title="{{ __('Remove') }}" data-original-title="{{ __('Remove') }}"></i>
                                            </button>
                                        </figure>
                                        @endif
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer2_id_back">{{ ("Customer 2 ID back") }}:</label> 
                                            <input type="file" name="attachments[customer2_id_back]" id="customer2_id_back" class="form-control-file">
                                        </div>
                                        @if( isset($attachments['customer2_id_back']) )
                                        <figure class="figure position-relative">
                                            <a href="" target="_blank">
                                                <img src="{{$attachments['customer2_id_back']['path']}}" class="figure-img img-fluid rounded">
                                            </a>
                                            <button class="btn btn-danger btn-xs thumbnial-delete-btn" data-attachment-id="{{ $attachments['customer2_id_back']['id'] }}"> 
                                                <i class="fas fa-trash-alt" data-toggle="tooltip"  data-placement="top" title="{{ __('Remove') }}" data-original-title="{{ __('Remove') }}"></i>
                                            </button>
                                        </figure>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer1_passport_image">{{ __("Customer 1 Passport") }}:</label>    
                                            <input type="file" name="attachments[customer1_passort]" id="customer1_passport_image" class="form-control-file">
                                        </div>
                                        @if( isset($attachments['customer1_passort']) )
                                        <figure class="figure position-relative">
                                            <a href="" target="_blank">
                                                <img src="{{$attachments['customer1_passort']['path']}}" class="figure-img img-fluid rounded">
                                            </a>
                                            <button class="btn btn-danger btn-xs thumbnial-delete-btn" data-attachment-id="{{ $attachments['customer1_passort']['id'] }}"> 
                                                <i class="fas fa-trash-alt" data-toggle="tooltip"  data-placement="top" title="{{ __('Remove') }}" data-original-title="{{ __('Remove') }}"></i>
                                            </button>
                                        </figure>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer2_passort">{{ __("Customer 2 Passport") }}:</label>    
                                            <input type="file" name="attachments[customer2_passort]" id="customer2_passort" class="form-control-file">
                                        </div>
                                        @if( isset($attachments['customer2_passort']) )
                                        <figure class="figure position-relative">
                                            <a href="" target="_blank">
                                                <img src="{{$attachments['customer2_passort']['path']}}" class="figure-img img-fluid rounded">
                                            </a>
                                            <button class="btn btn-danger btn-xs thumbnial-delete-btn" data-attachment-id="{{ $attachments['customer2_passort']['id'] }}"> 
                                                <i class="fas fa-trash-alt" data-toggle="tooltip"  data-placement="top" title="{{ __('Remove') }}" data-original-title="{{ __('Remove') }}"></i>
                                            </button>
                                        </figure>
                                        @endif
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
                            </div>
                            <div class="col">                                
                                <a href="{{ route('admin.contracts.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Contract") }} {{__("List")}}</a>
                                @if ( $contract->isEditable() )
                                <button type="submit" value="validate" class="btn btn-success float-right mx-2">{{ __("Save & Print") }} {{ __("Contract") }}</button>
                                @else
                                    <a href="{{ route('admin.contracts.print', [ 'id' => $contract->id]) }}" class="btn btn-success float-right mx-2">{{ __('Print').' '.__('Contract') }}</a>
                                @endif                                
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
            if ( $(this).parent().prev("li")[0] == undefined ) {
                $('.tab-nav-next').removeClass('d-none');                
            }        
            if ( $(this).parent().prev("li")[0] != undefined &&  $(this).parent().next("li")[0] != undefined) {
                $('.tab-nav-next').removeClass('d-none');
                $('.tab-nav-pre').removeClass('d-none');
            }     
            if (  $(this).parent().next("li")[0] == undefined ) {                
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
            }
            if ( $('.nav-tabs .active').parent().prev('li')[0] == undefined ) {                               
                $(this).addClass('d-none');
            }
        });

        $('.thumbnial-delete-btn').on('click', function (e){
            e.preventDefault();
            var ele = $(this);
            axios.delete('/admin/contract_attachments/' + $(this).data('attachmentId'))
            .then(function (response) {
                if ( response.data.status == 'success' ) {
                    ele.parent('figure').remove();
                } else if ( response.data.status == 'error') {
                    alert(response.data.status.message);
                }
            })
            .catch(function (error) {       
                alert(error);
                console.log(error);
            });        
        });
    });
</script>
@endpush
