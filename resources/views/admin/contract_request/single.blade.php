@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">Contract Request : <strong>{{ $contract_request->createdBy->name }} ({{ $contract_request->unit_code }})</strong></div>
                <form method="POST" action="{{ route('admin.contract_request.update', ['id'=> $contract_request->id]) }}" novalidate="novalidate" autocomplete="false">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
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
                    <h5 id="customer-information">Customer Information:</h5>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label for="customer1_name">Customer Name 1:</label>
                                <input type="text" class="form-control" id="customer1_name" value="{{ $contract_request->customer1_name }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="customer1_gender">Gender:</label>
                                <input type="text" class="form-control" id="customer1_gender" value="{{ $contract_request->getCustomer1GenderFormatted() }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="customer1_birthdate">Date of Birth</label>
                                <input type="text" class="form-control datepicker" name="customer1_birthdate" id="customer1_birthdate" value="{{ $contract_request->customer1_birthdate->toDateString() }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label for="customer1_nid">Identity Number</label>
                                <input type="text" class="form-control" name="customer1_nid" id="customer1_nid" value="{{ $contract_request->customer1_nid }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer1_nid_issued_date">ID Issued Date:</label>
                                <input type="text" class="form-control datepicker" name="customer1_nid_issued_date" id="customer1_nid_issued_date" value="{{ $contract_request->customer1_nid_issued_date->toDateString() }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label for="customer2_name">Customer Name 2:</label>
                                <input type="text" class="form-control" id="customer2_name" value="{{ $contract_request->customer2_name }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Gender:</label>
                                <input type="text" class="form-control" id="customer2_gender" value="{{ $contract_request->getCustomer2GenderFormatted() }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="customer2_birthdate">Date of Birth</label>
                                <input type="text" class="form-control datepicker" name="customer2_birthdate" id="customer2_birthdate" value="{{ $contract_request->customer2_birthdate->toDateString() }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label for="customer1_nid">Identity Number</label>
                                <input type="text" class="form-control" name="customer2_nid" id="customer2_nid" value="{{ $contract_request->customer2_nid }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer1_nid_issued_date">ID Issued Date:</label>
                                <input type="text" class="form-control datepicker" name="customer2_nid_issued_date" id="customer2_nid_issued_date" value="{{ $contract_request->customer2_nid_issued_date->toDateString() }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label for="customer_phone_number">Customer Phone Number 1:</label>
                                <input type="text" class="form-control" id="customer_phone_number" value="{{ $contract_request->customer_phone_number }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label for="customer_phone_number2">Customer Phone Number 2:</label>
                                <input type="text" class="form-control" id="customer_phone_number2" value="{{ $contract_request->customer_phone_number2 }}" readonly="readonly">
                            </div>
                        </div>                           
                    </div>
                    <h5 id="address-information">Address Information:</h5>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="customer_house_no">House No.:</label>
                                <input type="text" class="form-control" name="customer_house_no" id="customer_house_no" value="{{ $contract_request->customer_house_no }}">
                            </div>
                        </div>
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="customer_street">Street:</label>
                                <input type="text" class="form-control" name="customer_street" id="customer_street" value="{{ $contract_request->customer_street }}">
                            </div>
                        </div>
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="customer_phum">Phum:</label>
                                <input type="text" class="form-control" name="customer_phum" id="customer_phum" value="{{ $contract_request->customer_phum }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="customer_commune">Sangkat / Commune (ឃុំ)</label>
                                <input type="text" class="form-control" name="customer_commune" id="customer_commune" value="{{ $contract_request->customer_commune }}">
                            </div>
                        </div>
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="customer_district">Kanh / District (ស្រុក)</label>
                                <input type="text" class="form-control" name="customer_district" id="customer_district" value="{{ $contract_request->customer_district }}">
                            </div>
                        </div>
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="customer_city">City / Province (ខេត្ត)</label>
                                <input type="text" class="form-control" name="customer_city" id="customer_city" value="{{ $contract_request->customer_city }}">
                            </div>
                        </div>
                    </div>
                    <h5 id="agent-information">Agent Information:</h5>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-md-9"> 
                            <div class="form-group">
                                <label for="agent_name">Agent Name:</label>
                                <input type="text" class="form-control" id="agent_name" value="{{ $contract_request->agent_name }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-3"> 
                            <div class="form-group">
                                <label for="agent_gender">Gender</label>
                                <input type="text" class="form-control" id="agent_gender" value="{{ $contract_request->getAgentGenderFormatted() }}" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label for="agent_phone_number">Agent Phone Number:</label>
                                <input type="text" class="form-control" id="agent_phone_number" value="{{ $contract_request->agent_phone_number }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label for="sale_team_leader">Sale Team Leader:</label>
                                <input type="text" class="form-control" id="sale_team_leader" value="{{ $contract_request->saleTeamLeader->name }}" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label for="agent_remark">Agent Remark:</label>
                                <textarea class="form-control" id="agent_remark" rows="3" readonly="readonly">{{ $contract_request->agent_remark }}</textarea>
                            </div>
                        </div>                            
                    </div>
                    <h5 id="unit-information">Unit Information:</h5>
                    <hr class="mt-0">     
                    <div class="row">
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="unit_code">Unit Code:</label>
                                <input type="text" class="form-control" id="unit_code" value="{{ $contract_request->unit->code }}" readonly="readonly">
                            </div>
                        </div>                        
                        <div class="col-md"> 
                            <div class="form-group">
                                <label for="unit_type">Unit Type</label>
                                <input type="text" class="form-control" id="unit_type" value="{{ $contract_request->unit->unitType->name }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md"> 
                            <div class="form-group">
                                <label for="project">Project:</label>
                                <input type="text" class="form-control" id="project" value="{{ $contract_request->unit->unitType->project->name_en }}" readonly="readonly">
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="unit_sold_price">Sold Price ($):</label>
                                <input type="text" class="form-control" id="unit_sold_price" value="{{ number_format($contract_request->unit_sold_price, 2) }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="discount_promotion">Discount Promotion ($):</label>
                                <input type="text" class="form-control" id="discount_promotion" value="{{ number_format($contract_request->discount_promotion, 2) }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="unit_sold_date">Sold Date:</label>
                                <input type="text" class="form-control" id="unit_sold_date" value="{{ $contract_request->unit_sold_date->toFormattedDateString() }}" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md form-group">
                            <label for="street">Street</label>
                            <input type="text" id="street" value="{{ $contract_request->unit->street }}" class="form-control" readonly="readonly">
                        </div>
                        <div class="col-md form-group">
                            <label for="street_corner">Street Corner</label>
                            <input type="text" id="street_corner" value="{{ $contract_request->unit->street }}" class="form-control" readonly="readonly">
                        </div>
                        <div class="col-md form-group">
                            <label for="street_size">Street Size</label>
                            <input type="text" id="street_size" value="{{ $contract_request->unit->street_size }}" class="form-control" readonly="readonly">
                        </div>
                        <div class="col-md form-group">
                            <label for="floor">Floor</label>
                            <input type="text" id="floor" value="{{ $contract_request->unit->floor }}" class="form-control" readonly="readonly">
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="land_size_width">Land Width:</label>
                                <input type="text" class="form-control" id="land_size_width" value="{{ $contract_request->unit->land_size_width }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="land_size_length">Land Length:</label>
                                <input type="text" class="form-control" id="land_size_length" value="{{ $contract_request->unit->land_size_length }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="building_size_width">House Width:</label>
                                <input type="text" class="form-control" id="building_size_width" value="{{ $contract_request->unit->building_size_width }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="building_size_length">House Length:</label>
                                <input type="text" class="form-control" id="building_size_length" value="{{ $contract_request->unit->building_size_length }}" readonly="readonly">
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="living_room">Living Room:</label>
                                <input type="text" class="form-control" id="living_room" value="{{ $contract_request->unit->living_room }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="kitchen">Kitchen:</label>
                                <input type="text" class="form-control" id="kitchen" value="{{ $contract_request->unit->kitchen }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="bedroom">Bedroom:</label>
                                <input type="text" class="form-control" id="bedroom" value="{{ $contract_request->unit->bedroom }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="bathroom">Bathroom:</label>
                                <input type="text" class="form-control" id="bathroom" value="{{ $contract_request->unit->bathroom }}" readonly="readonly">
                            </div>
                        </div>                        
                    </div> 
                    <h5 id="discount-and-deposit">Other Discount and Deposit:</h5>
                    <hr class="mt-0">  
                    <div class="row">
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="other_discount_allowed">Other Discount Allowance ($):</label>
                                <input type="text" class="form-control" id="other_discount_allowed" value="{{ number_format($contract_request->other_discount_allowed, 2) }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="deposited_amount">Deposited Amount ($):</label>
                                <input type="text" class="form-control" id="deposited_amount" value="{{ number_format($contract_request->deposited_amount, 2) }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label for="deposited_date">Deposited Date:</label>
                                <input type="text" class="form-control" id="deposited_date" value="{{ $contract_request->deposited_date->toFormattedDateString() }}" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label for="unit_remark">Unit Remark:</label>
                                <textarea class="form-control" id="unit_remark" rows="3" readonly="readonly">{{ $contract_request->unit_remark }}</textarea>
                            </div>
                        </div>                            
                    </div>
                    <h5 id="payment-option">Payment Option:</h5>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="payment_option">Selected Payment Option:</label>
                            <input type="text" class="form-control" id="payment_option" value="{{ is_null($payment_option_array['id']) ? 'Other' : $payment_option_array['name'] }}" readonly="readonly">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="payment_day">Start Payment Date:</label>
                            <input type="text" class="form-control" id="start_payment_date" value="{{ $contract_request->start_payment_date->toDateString() }}" readonly="readonly">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="sign_date">Contract Sign Date:</label>
                            <input type="text" class="form-control" id="sign_date" value="{{ $contract_request->sign_date->toFormattedDateString() }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg form-group">
                            <label for="loan_duration">Loan Duration</label>
                            <input type="text" id="loan_duration" class="form-control" value="{{ $payment_option_array['loan_duration'] }}" readonly="readonly" />
                        </div>
                        <div class="col-lg form-group">
                            <label for="interest">Interest</label>
                            <input type="text" id="interest" class="form-control" value="{{ $payment_option_array['interest'] }}" readonly="readonly" />
                        </div>
                        <div class="col-lg form-group">
                            <label for="special_discount">Special Discount (%)</label>
                            <input type="text" id="special_discount" class="form-control" value="{{ $payment_option_array['special_discount'] }}" readonly="readonly" />
                        </div>
                    </div>                   
                    <div class="row">
                        <div class="col-lg form-group">
                            <label for="is_first_payment">First Payment</label>
                            <input type="text" id="is_first_payment" class="form-control" value="{{ $payment_option_array['is_first_payment'] ? 'Yes' : 'No'}}" readonly="readonly" />
                        </div>
                        <div class="col-lg form-group">
                            <label for="first_payment_duration">First Payment Duration</label>
                            <input type="text" id="first_payment_duration" class="form-control" value="{{ $payment_option_array['first_payment_duration'] }}" readonly="readonly" />
                        </div>
                        <div class="col-lg form-group">
                            <label for="first_payment_amount">{{ $payment_option_array['first_payment_percentage'] ? 'First Payment Percentage' : 'First Payment Amount' }}</label>
                            <input type="text" id="first_payment_amount" class="form-control" value="{{ $payment_option_array['first_payment_percentage'] ? $payment_option_array['first_payment_percentage']  : $payment_option_array['first_payment_amount'] }}" readonly="readonly" />
                        </div>
                    </div> 
                    <h5 id="attachment" class="mb-0">Attachments:</h5> 
                    <div class="row">      
                        @foreach( $contract_request->attachments as $img )
                        <a href="{{ $img->path }}" class="thumbnail-wrapper" target="_blank">
                            <img src="{{ $img->path }}" alt="..." class="img-thumbnail img-fluid">
                        </a>
                        @endforeach
                    </div>                                                    
                </div>
                <div class="card-footer">                    
                    <div class="row">
                        @role('contract_controller')
                        <div class="col">                           
                            <button type="submit" class="btn btn-primary">{{ __("Update") }}</button>
                        </div>
                        @endrole
                        <div class="col">
                            <a href="{{ route('admin.contract_request.all') }}" class="btn btn-secondary float-right">Back to Contract Request List</a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>     
        <div class="col-lg-3 d-none-sm d-sm-none d-none d-md-none d-lg-block">
            <div id="scrollspy-list" class="list-group sticky-top">
                <a class="list-group-item list-group-item-action" href="#customer-information">Customer Information</a>
                <a class="list-group-item list-group-item-action" href="#address-information">Address Information</a>
                <a class="list-group-item list-group-item-action" href="#agent-information">Agent Information</a>
                <a class="list-group-item list-group-item-action" href="#unit-information">Unit Information</a>
                <a class="list-group-item list-group-item-action" href="#discount-and-deposit">Other Discount and Deposit</a>
                <a class="list-group-item list-group-item-action" href="#payment-option">Payment Option</a>
                <a class="list-group-item list-group-item-action" href="#attachment">Attachment</a>
            </div>
        </div>   
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function (){
        $('body').scrollspy({ target: '#scrollspy-list', offset: 50 });
        $('.datepicker').datepicker({format: 'yyyy-mm-dd', orientation : "bottom", autoclose : true});       
    });
</script>
@endpush