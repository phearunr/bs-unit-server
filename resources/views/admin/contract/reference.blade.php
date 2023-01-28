@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.contracts.create') }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data" id="create-contract-form">
        @csrf    
        <input type="hidden" name="contract_request_id" value="{{ $contract_request ? $contract_request->id : '' }}">  
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
                                <a class="nav-link" id="agent-tab" data-toggle="tab" href="#agent" role="tab" aria-controls="agent" aria-selected="true">Agent & Unit Info.</a>
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
                                <h5 id="customer-information">Personal Information:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg-3"> 
                                        <div class="form-group">
                                            <label for="customer1_name">Customer Name 1:</label>
                                            <input type="text" name="customer1_name" id="customer1_name" 
                                                value="{{ old('customer1_name') ? old('customer1_name') : $contract_request->customer1_name }}"
                                                class="form-control{{ $errors->has('customer1_name') ? ' is-invalid' : '' }}">
                                            @if(  $errors->has('customer1_name'))
                                            <div class="invalid-feedback">{{ $errors->first('customer1_name') }}</div> 
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="customer1_gender">Gender:</label>
                                            <select class="form-control" name="customer1_gender" id="customer1_gender">
                                                <option value="1" {{ $contract_request->customer1_gender == 1 ? 'selected' : '' }}>Male</option>
                                                <option value="2" {{ $contract_request->customer1_gender == 2 ? 'selected' : '' }}>Female</option>
                                            </select>                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="customer1_birthdate">Date of Birth</label>
                                            <input type="text" class="form-control datepicker" name="customer1_birthdate" id="customer1_birthdate" 
                                                value="{{ old('customer1_birthdate') ? old('customer1_birthdate') : (is_null($contract_request->customer1_birthdate) ? date('Y-m-d') : $contract_request->customer1_birthdate->toDateString()) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3"> 
                                        <div class="form-group">
                                            <label for="customer1_nid">Identity Number</label>
                                            <input type="text" name="customer1_nid" id="customer1_nid" 
                                                value="{{ old('customer1_nid') ? old('customer1_nid') : $contract_request->customer1_nid }}"
                                                class="form-control{{ $errors->has('customer1_nid') ? ' is-invalid' : '' }}" >
                                            @if(  $errors->has('customer1_nid'))
                                            <div class="invalid-feedback">{{ $errors->first('customer1_nid') }}</div> 
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="customer1_nid_issued_date">ID Issued Date:</label>
                                            <input type="text" class="form-control datepicker" name="customer1_nid_issued_date" id="customer1_nid_issued_date" value="{{ is_null($contract_request->customer1_nid_issued_date) ? date('Y-m-d') : $contract_request->customer1_nid_issued_date->toDateString() }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check pb-2">
                                            <input type="checkbox" class="form-check-input" name="second_customer" id="second_customer" data-toggle="collapse" href="#second_customer_container" {{ old('second_customer') ? 'checked' : '' }}>
                                            <label class="form-check-label text-primary" for="second_customer">This contract will contain 2 customers</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row collapse{{ old('second_customer') ? ' show' : '' }}" id="second_customer_container">
                                    <div class="col-lg-3"> 
                                        <div class="form-group">
                                            <label for="customer1_name">Customer Name 2:</label>
                                            <input type="text" class="form-control" name="customer2_name"  id="customer2_name" value="{{ $contract_request->customer2_name }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="customer2_gender">Gender:</label>
                                            <select class="form-control" name="customer2_gender" id="customer2_gender">
                                                <option value="1" {{ $contract_request->customer2_gender == 1 ? 'selected' : '' }}>Male</option>
                                                <option value="2" {{ $contract_request->customer2_gender == 2 ? 'selected' : '' }}>Female</option>
                                            </select>  
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="customer1_birthdate">Date of Birth</label>
                                            <input type="text" class="form-control datepicker" name="customer2_birthdate" id="customer1_birthdate" value="{{ is_null($contract_request->customer2_birthdate) ? date('Y-m-d') : $contract_request->customer2_birthdate->toDateString() }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3"> 
                                        <div class="form-group">
                                            <label for="customer1_nid">Identity Number</label>
                                            <input type="text" class="form-control" name="customer2_nid" id="customer1_nid" value="{{ $contract_request->customer2_nid }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="customer1_nid_issued_date">ID Issued Date:</label>
                                            <input type="text" class="form-control datepicker" name="customer2_nid_issued_date" id="customer1_nid_issued_date" value="{{ is_null($contract_request->customer2_nid_issued_date) ? date('Y-m-d') : $contract_request->customer2_nid_issued_date->toDateString() }}">
                                        </div>
                                    </div>
                                </div>
                                <h5 id="customer-information">Contact Information:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="customer_phone_number">Customer Phone Number 1:</label>
                                            <input type="text" name="customer_phone_number" id="customer_phone_number" 
                                                value="{{ old('customer_phone_number') ? old('customer_phone_number') : $contract_request->customer_phone_number }}"
                                                class="form-control{{ $errors->has('customer_phone_number') ? ' is-invalid' : '' }}">
                                            @if(  $errors->has('customer_phone_number'))
                                            <div class="invalid-feedback">{{ $errors->first('customer_phone_number') }}</div> 
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="customer_phone_number2">Customer Phone Number 2:</label>
                                            <input type="text" class="form-control" name="customer_phone_number2" id="customer_phone_number2" value="{{ $contract_request->customer_phone_number2 }}">
                                        </div>
                                    </div>
                                </div>
                                <h5 id="customer-information">Address Information:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer_house_no">House No.:</label>
                                            <input type="text" name="customer_house_no" id="customer_house_no" 
                                                   value="{{ old('customer_house_no') ? old('customer_house_no') : $contract_request->customer_house_no }}"
                                                   class="form-control{{ $errors->has('customer_house_no') ? ' is-invalid' : '' }}">
                                            @if(  $errors->has('customer_house_no'))
                                            <div class="invalid-feedback">{{ $errors->first('customer_house_no') }}</div> 
                                            @endif                                          
                                        </div>
                                       
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer_street">Street:</label>
                                            <input type="text" name="customer_street" id="customer_street"
                                                   value="{{ old('customer_street')? old('customer_street') : $contract_request->customer_street }}"
                                                   class="form-control{{ $errors->has('customer_street') ? ' is-invalid' : '' }}">
                                            @if(  $errors->has('customer_street'))
                                            <div class="invalid-feedback">{{ $errors->first('customer_street') }}</div> 
                                            @endif   
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer_phum">Phum:</label>
                                            <input type="text" name="customer_phum" id="customer_phum" 
                                                   value="{{ old('customer_phum') ? old('customer_phum') : $contract_request->customer_phum }}"
                                                   class="form-control{{ $errors->has('customer_phum') ? ' is-invalid' : '' }}">
                                            @if(  $errors->has('customer_phum'))
                                            <div class="invalid-feedback">{{ $errors->first('customer_phum') }}</div> 
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="customer_commune">Sangkat / Commune (ឃុំ)</label>
                                            <input type="text" name="customer_commune" id="customer_commune" 
                                                value="{{ old('customer_commune') ? old('customer_commune') : $contract_request->customer_commune }}"
                                                class="form-control{{ $errors->has('customer_commune') ? ' is-invalid' : '' }}">
                                            @if(  $errors->has('customer_commune'))
                                            <div class="invalid-feedback">{{ $errors->first('customer_commune') }}</div> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="customer_district">Kanh / District (ស្រុក)</label>
                                            <input type="text" name="customer_district" id="customer_district" 
                                                value="{{ old('customer_district') ? old('customer_district') : $contract_request->customer_district }}"
                                                class="form-control{{ $errors->has('customer_district') ? ' is-invalid' : '' }}">
                                            @if(  $errors->has('customer_district'))
                                            <div class="invalid-feedback">{{ $errors->first('customer_district') }}</div> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="customer_city">City / Province (ខេត្ត)</label>
                                            <input type="text" name="customer_city" id="customer_city" 
                                                value="{{ old('customer_city') ? old('customer_city') : $contract_request->customer_city }}"
                                                class="form-control{{ $errors->has('customer_city') ? ' is-invalid' : '' }}">
                                            @if(  $errors->has('customer_city'))
                                            <div class="invalid-feedback">{{ $errors->first('customer_city') }}</div> 
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="agent" role="tabpanel" aria-labelledby="agent-tab">
                                <h5 id="customer-information">Agent Information:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg-4"> 
                                        <div class="form-group">
                                            <label for="agent_name">Agent Name:</label>
                                            <input type="text" name="agent_name" id="agent_name" 
                                                value="{{ $contract_request->agent_name }}"
                                                class="form-control{{ $errors->has('agent_name') ? ' is-invalid' : '' }}">
                                            @if(  $errors->has('agent_name'))
                                            <div class="invalid-feedback">{{ $errors->first('agent_name') }}</div> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-2"> 
                                        <div class="form-group">
                                            <label for="agent_gender">Gender</label>                                          
                                            <select class="form-control" name="agent_gender" id="agent_gender">
                                                <option value="1" {{ $contract_request->agent_gender == 1 ? 'selected' : '' }}>Male</option>
                                                <option value="2" {{ $contract_request->agent_gender == 2 ? 'selected' : '' }}>Female</option>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-lg-3"> 
                                        <div class="form-group">
                                            <label for="agent_phone_number">Agent Phone Number:</label>
                                            <input type="text" name="agent_phone_number" id="agent_phone_number" 
                                                value="{{ $contract_request->agent_phone_number }}"
                                                class="form-control{{ $errors->has('agent_phone_number') ? ' is-invalid' : '' }}">
                                            @if(  $errors->has('agent_phone_number'))
                                            <div class="invalid-feedback">{{ $errors->first('agent_phone_number') }}</div> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3"> 
                                        <div class="form-group">
                                            <label for="sale_team_leader">Sale Team Leader:</label>
                                            <select class="form-control select2{{ $errors->has('sale_team_leader_id') ? ' is-invalid' : '' }}" name="sale_team_leader_id">
                                                @foreach($sale_team_leaders as $user) 
                                                    <option value="{{ $user->id }}" {{ ( old('sale_team_leader_id') ? old('sale_team_leader_id') : $contract_request->sale_team_leader_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                @endforeach
                                            </select> 
                                            @if(  $errors->has('sale_team_leader'))
                                            <div class="invalid-feedback">{{ $errors->first('sale_team_leader') }}</div> 
                                            @endif                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12"> 
                                        <div class="form-group">
                                            <label for="agent_remark">Agent Remark:</label>
                                            <textarea class="form-control{{ $errors->has('agent_remark') ? ' is-invalid' : '' }}" name="agent_remark" id="agent_remark" rows="3">{{ old('agent_remark') ? old('agent_remark') : $contract_request->agent_remark }}</textarea>
                                            @if(  $errors->has('agent_remark'))
                                            <div class="invalid-feedback">{{ $errors->first('agent_remark') }}</div> 
                                            @endif  
                                        </div>
                                    </div>                            
                                </div>
                                <h5 id="unit-information">Unit Type:</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg-4"> 
                                        <div class="form-group">
                                            <label for="unit_type">Unit Type</label>
                                            <select class="form-control select2" id="unit_type_id">
                                                @foreach ( $projects as $project )
                                                    <optgroup label="{{ $project->name }}">
                                                    @foreach( $project->unitTypes as $ut )
                                                        <option value="{{ $unit_type->id }}" 
                                                                {{ $ut->id == $unit->unitType->id ? "selected" : "" }} >
                                                                {{ $ut->name }} ({{ $project->name }})
                                                        </option>
                                                    @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="annual_management_fee">Annual Management Fee:</label>
                                            <input type="text" min="0" name="annual_management_fee" id="annual_management_fee" 
                                                value="{{ $unit_type->annual_management_fee }}"
                                                class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="contract_transfer_fee">Contract Transfer:</label>
                                            <input type="text" min="0" name="contract_transfer_fee" id="contract_transfer_fee" 
                                                value="{{ $unit_type->contract_transfer_fee }}"
                                                class="form-control" />                                           
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="management_fee_per_square">Mgt. Fee per Sqaure (Condo):</label>
                                            <input type="text" min="0" name="management_fee_per_square" id="management_fee_per_square" 
                                                value="{{ $unit_type->management_fee_per_square }}" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="deadline">Deadline</label>
                                        <input type="text" name="deadline" id="deadline" class="form-control" value="{{ $unit_type->deadline }}">
                                    </div>
                                     <div class="col-lg form-group">
                                        <label for="extended_deadline">Extended Deadline</label>
                                        <input type="text" name="extended_deadline" id="extended_deadline" class="form-control" value="{{ $unit_type->extended_deadline }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="title_clause_kh">Title Clause (KH):</label>
                                        <textarea class="form-control" rows="4" name="title_clause_kh" id="title_clause_kh">{{ $unit_type->title_clause_kh }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="">Management Service (KH):</label>
                                        <textarea class="form-control" rows="4" name="management_service_kh" id="management_service_kh">{{ $unit_type->management_service_kh }}</textarea>
                                    </div>
                                </div>
                                <h5 id="customer-information">Unit Information:</h5>
                                <hr class="mt-0">
                                
                                <div class="row">
                                    <div class="col-lg-4"> 
                                        <div class="form-group">
                                            <label for="unit_code">Unit Code:</label>
                                            <select class="form-control" name="unit_id" id="unit_id">
                                                <option value="{{ $unit->id }}" title="{{ $unit->code }}" selected="selected">{{ $unit->code }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="unit_price">Unit Price:</label>
                                            <input type="text" min="0" id="unit_price" 
                                                value="{{ $unit->price }}"
                                                class="form-control currency" readonly />
                                        </div>
                                    </div>                                     
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="unit_sold_date">Unit Sold Date:</label>
                                            <input type="text" class="form-control datepicker" name="unit_sold_date" id="unit_sold_date" 
                                                value="{{ old('unit_sold_date') ? old('unit_sold_date') : $contract_request->unit_sold_date->toDateString() }}"
                                                class="form-control datepicker">
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="unit_street">Sign Date:</label>
                                            <input type="text" class="form-control datepicker" name="sign_date" id="sign_date" 
                                                value="{{ old('sign_date') ? old('sign_date') : $contract_request->sign_date->toDateString() }}"
                                                class="form-control datepicker">
                                        </div>
                                    </div>                                                                      
                                </div>
                                <div class="row">
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="unit_street">Street:</label>
                                            <input type="text" id="unit_street" 
                                                value="{{ $unit->street }}" class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="unit_street_corner">Street Corner:</label>
                                            <input type="text" id="unit_street_corner" 
                                                value="{{ $unit->street_corner }}"
                                                class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="unit_street_size">Street Size:</label>
                                            <input type="text" id="unit_street_size" 
                                                value="{{ $unit->street_size }}" class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg"> 
                                        <div class="form-group">
                                            <label for="unit_floor">Unit Floor:</label>
                                            <input type="text" id="unit_floor" value="{{ $unit->unit_floor }}" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="land_size_width">Land Width:</label>
                                            <input type="number" id="land_size_width" value="{{ $unit->land_size_width }}" class="form-control" readonly />                                           
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="land_size_length">Land Length:</label>
                                            <input type="number" id="land_size_length" value="{{ $unit->land_size_length }}" class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="building_size_width">House Width:</label>
                                            <input type="number" id="building_size_width" value="{{ $unit->building_size_width }}" class="form-control" readonly />                                            
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="building_size_length">House Length:</label>
                                            <input type="number" id="building_size_length" value="{{ $unit->building_size_length }}" class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="total_area_size">Total Area:</label>
                                            <input type="number" id="total_area_size" value="{{ $unit->total_area_size }}" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg form-group">
                                        <label for="living_room">Living Room</label>
                                        <input type="text" id="living_room" class="form-control" value="{{ $unit->living_room }}" readonly>
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="kitchen">Kitchen</label>
                                        <input type="text" id="kitchen" class="form-control" value="{{ $unit->kitchen }}" readonly>
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="bedroom">Bedroom</label>
                                        <input type="text" id="bedroom" class="form-control" value="{{ $unit->bedroom }}" readonly>
                                    </div>
                                    <div class="col-lg form-group">
                                        <label for="bathroom">Bathroom</label>
                                        <input type="text" id="bathroom" class="form-control" value="{{ $unit->bathroom }}" readonly>
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
                            </div>                           
                            <div class="tab-pane fade" id="discount-payment" role="tabpanel" aria-labelledby="discount-payment-tab">
                               <div class="row">
                                    <div class="col-md-5">
                                        <h5>Payment Information</h5>
                                        <hr class="mt-0">
                                        <table class="table-couple">
                                            <tr>
                                                <td class="title" width="200px">Unit Price:</td>    
                                                <td class="p-0">                                                    
                                                    <input type="text" class="form-control  changable-price" name="unit_sold_price" value="{{$contract_request->unit_sold_price}}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title">Discount (Promotion):</td>                                                   
                                                <td class="p-0">                                                    
                                                    <input type="text" min="0" class="form-control changable-price" name="discount_promotion" value="{{$contract_request->discount_promotion}}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title">Discount (Others):</td>
                                                <td class="p-0">                                                    
                                                    <input type="text" class="form-control changable-price" name="other_discount_allowed" value="{{$contract_request->other_discount_allowed}}">
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="title">Price After discount:</td>
                                                <td class="text bg-grey"><span class="currency" id="price_after_discount">{{ $contract_request->getUnitSoldPriceAfterDiscount() }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Discount Payment Option:</td>
                                                <td class="text bg-grey"><span class="currency" id="discount_payment_option">{{ $contract_request->getDiscountAmountByPaymentOption() }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Final Price:</td>
                                                <td class="text bg-grey"><span class="currency" id="final_price">{{ $contract_request->getUnitSoldPriceAfterAllDiscount() }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Deposited Amount:</td>
                                                <td class="p-0">                                                    
                                                    <input type="text" class="form-control" name="deposited_amount" value="{{$contract_request->deposited_amount}}">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="title">Deposited Date:</td>
                                                <td class="p-0">                                                    
                                                    <input type="text" class="form-control datepicker" name="deposited_date" value="{{$contract_request->deposited_date->toDateString()}}">
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <td class="title">Start Payment Date:</td>
                                                <td class="p-0">     
                                                    <input type="text" class="form-control datepicker" name="start_payment_date" value="{{$contract_request->start_payment_date->toDateString()}}">
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="title">Start Payment No:</td>
                                                <td class="p-0">                                                    
                                                    <input type="number" min="0" class="form-control" name="start_payment_number" value="0">
                                                </td>                                                
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-7">
                                        <h5>Payment Option</h5>
                                        <hr class="mt-0">
                                        <table class="table-couple mb-3">
                                            <tr> 
                                                <td class="title" width="180px">Payment Option:</td>   
                                                <td class="p-0">
                                                    <select class="form-control" name="payment_option_id" id="payment_option">
                                                        @foreach($payment_options as $payment_option)
                                                        <option value="{{ $payment_option->id }}" {{ $contract_request->payment_option_id == $payment_option->id ? "selected" : "" }}>{{ $payment_option->name }}</option>
                                                        @endforeach
                                                        <option value="" {{ is_null($contract_request->payment_option_id) ? "selected" : "" }}>Other</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table-couple mb-3">
                                            <tr>
                                                <td class="title" width="180px">Have First Payment?:</td>
                                                <td class="p-0">
                                                    <select class="form-control" name="is_first_payment" id="is_first_payment">
                                                        <option value="0" selected="{{ $contract_request->is_first_payment ? '' : 'selected' }}">No</option>
                                                        <option value="1" selected="{{ $contract_request->is_first_payment ? 'selected' : '' }}">Yes</option>
                                                    </select>
                                                </td>
                                            </tr>                                            
                                            <tr class="collapse first_payment_field {{ $contract_request->is_first_payment ? 'show' : '' }}">
                                                <td class="title">Duration (Month):</td>
                                                <td class="p-0">
                                                    <input type="number" min="0" class="form-control" name="first_payment_duration" id="first_payment_duration" value="{{ $contract_request->first_payment_duration }}">
                                                </td>                                                
                                            </tr>                                   
                                            <tr class="collapse first_payment_field {{ $contract_request->is_first_payment ? 'show' : '' }}">
                                                <td class="title p-0">
                                                    <select class="form-control" id="first_payment_option" >
                                                        <option value="1" {{ is_null($contract_request->first_payment_percentage) || $contract->first_payment_percentage == 0 ? '' : 'selected' }}>Percentage (%)</option>
                                                        <option value="2" {{ is_null($contract_request->first_payment_amount) || $contract_request->first_payment_amount == 0 ? '' : 'selected' }}>Amount ($)</option>
                                                    </select>                                                    
                                                </td>
                                                <td class="p-0">
                                                    <input type="number" min="0" max="100" 
                                                            class="form-control {{ is_null($contract_request->first_payment_percentage) ? 'd-none' : '' }}" 
                                                            name="first_payment_percentage" 
                                                            id="first_payment_percentage" 
                                                            value="{{ $contract_request->first_payment_percentage }}"
                                                    >
                                                    <input type="number" min="0" 
                                                            class="form-control {{ is_null($contract_request->first_payment_amount) ? 'd-none' : '' }}" 
                                                            name="first_payment_amount" 
                                                            id="first_payment_amount" 
                                                            value="{{ $contract_request->first_payment_amount }}"
                                                    >
                                                </td>                                                
                                            </tr>
                                        </table>
                                        <table class="table-couple">
                                            <tr>
                                                <td class="title" width="180px">Loan Duration (Month):</td>   
                                                <td class="p-0">
                                                    <input type="number" min="1" class="form-control" name="loan_duration" id="loan_duration" value="{{ $contract_request->loan_duration }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title">Interest Rate (%):</td>
                                                <td class="p-0">
                                                    <input type="number" min="0" max="100" class="form-control" name="interest" id="interest" value="{{ $contract_request->interest }}">
                                                </td>
                                            </tr>                                  
                                            <tr>
                                                <td class="title">Special Discount (%):</td>
                                                <td class="p-0">
                                                    <input type="number" min="0" max="100" class="form-control changable-price" name="special_discount" id="special_discount" value="{{ $contract_request->special_discount }}">
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <td class="title">Rounding Result:</td>
                                                <td class="p-0">
                                                    <select class="form-control" name="loan_result_rounding" id="loan_result_rounding">
                                                        <option value="0" {{ $contract_request->loan_result_rounding ? '' : 'selected' }}>No</option>
                                                        <option value="1" {{ $contract_request->loan_result_rounding ? 'selected' : '' }}>Yes</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-auto py-3">
                                        <button type="button" class="btn btn-primary" id="btn-show-loan">Show Schedule</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h5>Installment Plan</h5>
                                        <hr class="mt-0">                                        
                                        <table class="table table-bordered" id="first_payment_table">
                                            <thead>
                                                <tr class="bg-grey">
                                                    <th colspan="6" class="text-center">First Payment</th>
                                                </tr>
                                                <tr class="bg-grey">
                                                    <th>No</th>
                                                    <th>Payment Date</th>
                                                    <th>Beginning Bal.</th>
                                                    <th>Payment Amount</th>
                                                    <th>Ending Bal.</th>
                                                    <th>Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                               
                                            </tbody>
                                        </table>                                      
                                        <table class="table table-bordered" id="payment_schedule_table">
                                            <thead>
                                                <tr class="bg-grey">
                                                    <th colspan="7" class="text-center">Payment Schedule</th>
                                                </tr>
                                                <tr class="bg-grey">
                                                    <th>No</th>
                                                    <th>Payment Date</th>
                                                    <th>Beginning Bal.</th>
                                                    <th>Payment Amount</th>
                                                    <th>Principle</th>
                                                    <th>Interest</th>
                                                    <th>Ending Bal.</th>
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
                                            <label for="customer1_id_front">Customer 1 ID front:</label>    
                                            <input type="file" name="attachments[customer1_id_front]" id="customer1_id_front" class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer1_id_back">Customer 1 ID back:</label> 
                                            <input type="file" name="attachments[customer1_id_back]" id="customer1_id_back" class="form-control-file">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer2_id_front">Customer 2 ID front:</label>    
                                            <input type="file" name="attachments[customer2_id_front]" id="customer2_id_front" class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer2_id_back">Customer 2 ID back:</label> 
                                            <input type="file" name="attachments[customer2_id_back]" id="customer2_id_back" class="form-control-file">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer1_passport_image">Customer 1 Passport:</label>    
                                            <input type="file" name="attachments[customer1_passort]" id="customer1_passport_image" class="form-control-file">
                                        </div>
                                    </div>                                 
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="customer2_passort">Customer 2 Passport:</label>    
                                            <input type="file" name="attachments[customer2_passort]" id="customer2_passort" class="form-control-file">
                                        </div>
                                    </div>                                 
                                </div>
                                <!-- <div class="custom-file-container" data-upload-id="myFirstImage">                                   
                                    <label class="custom-file-container__custom-file" >
                                        <input type="file" name="attachments[]" class="custom-file-container__custom-file__custom-file-input" accept="image/*" multiple>
                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                    </label>
                                    <div class="custom-file-container__image-preview" style="height:500px;"></div>
                                    <label><a href="javascript:void(0)" class="custom-file-container__image-clear btn btn-danger btn-sm" title="Clear Image">Remove All Images</a></label>
                                </div> -->
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
                                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Contract") }} {{__("List")}}</a>
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
    function formatUnit (unit) {        
        if (unit.loading) {
            return unit.text;
        }            
        return '<span class="d-block">' + unit.code + " | $" + $.number(unit.price,2) + '</span>';
    }

    function formatUnitSelection (unit) {
        if ( !unit.id ){
            return "Please select a unit";
        }
        $("#unit_street").val(unit.street);
        $("#unit_street_corner").val(unit.street_corner);  
        $("#unit_street_size").val(unit.street_size);  
        $("#unit_floor").val(unit.floor);
        $("#unit_land_width").val(unit.land_size_width);
        $("#unit_land_length").val(unit.land_size_length);
        $("#unit_house_width").val(unit.building_size_width);
        $("#unit_house_length").val(unit.building_size_length);
        $("#unit_total_area").val(unit.total_area_size);
        $('#unit_price').val(unit.price);
        $('input[name="unit_sold_price"]').val(unit.price);
       
        var option = new Option(unit.code, unit.id, true, true);

        return option;
    }

    $(document).ready(function (){
        var unit_select2 = $("#unit_id");
        unit_select2.on("click", function (e) {
            unit_select2.empty();
            unit_select2.select2({
                theme: "bootstrap4",
                ajax: {
                    delay: 500,                            
                    url: "/admin/units",
                    dataType: 'json',            
                    data: function (params) {
                        return {
                            term : $.trim(params.term),
                            unit_type : $("#unit_type_id").val()
                        };
                    },
                    processResults: function (data, params) {                 
                        params.page = params.page || 1;
                        return {
                            results: data.data,                      
                        };
                    }
                },
                escapeMarkup: function (markup) { return markup; },
                minimumInputLength: 3,   
                placeholder: 'Select a unit',
                templateResult: formatUnit,
                templateSelection: formatUnitSelection
            }).select2("open"); 
        });

        $('#unit_type_id').on('select2:select', function (e) {          
            var id = e.params.data.id;
            loadPaymentOption(id);
            loadUnitTypeData(id);
        });

        $("#unit_type_id").trigger("change");

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
