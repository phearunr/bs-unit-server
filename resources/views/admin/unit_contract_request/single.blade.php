@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-3 d-none-sm d-sm-none d-none d-md-none d-lg-block">
            <div id="scrollspy-list" class="list-group sticky-top">
                <a class="list-group-item list-group-item-action" href="#customer-information">{{ __("Customer Information") }}</a>
                <a class="list-group-item list-group-item-action" href="#unit-information">{{ __("Unit Information") }}</a> 
                <a class="list-group-item list-group-item-action" href="#pricing-information">{{ __("Pricing Information") }}</a> 
                <a class="list-group-item list-group-item-action" href="#payment-option">{{ __("Payment Option") }}</a>        
                <a class="list-group-item list-group-item-action" href="#agent-information">{{ __("Agent Information") }}</a>               
                <a class="list-group-item list-group-item-action" href="#attachment">{{ __("Attachment") }}</a>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    Unit Contract Request : <strong>{{ $unit_contract_request->unit->code }}</strong> {!! $unit_contract_request->getStatusHtml() !!}
                    @if( is_null($unit_contract_request->contract_id) )
                        @if( $unit_contract_request->status == \App\Helpers\UnitContractStatus::PENDING )
                        <a href="{{ route('admin.unit_contract_requests.create_contract', ['id' => $unit_contract_request->id]) }}" class="btn btn-sm btn-primary float-right">{{ __("Create Contract") }}</a>
                        @endif
                    @else
                        <a href="{{ route('admin.contracts.edit', ['id' => $unit_contract_request->contract_id]) }}" class="btn btn-sm btn-primary float-right">{{ __("View Contract") }}</a>
                    @endif
                    <a href="{{ route('admin.unit_contract_requests.print', ['id' => $unit_contract_request->id]) }}" class="btn btn-sm btn-success float-right mr-2">{{ __("Print") }} {{ __("Request") }}</a>
                </div>
                <form method="POST" action="{{ route('admin.contract_request.update', ['id'=> $unit_contract_request->id]) }}" novalidate="novalidate" autocomplete="false">
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
                    <h5 id="customer-information">{{ __("Customer Information") }}:</h5>
                    <hr class="mt-0">
                    <div class="row">                       
                        <div class="col-md-9 form-group">
                            <label for="customer1_name">{{ __("Customer Name") }}:</label>
                            <input type="text" class="form-control" id="customer_name" value="{{ $unit_contract_request->unitDepositRequest->customer_name }}" readonly="readonly">
                        </div>                       
                        <div class="col-md-3 form-group">
                            <label for="customer1_gender">{{ __("Gender") }}:</label>
                            <input type="text" class="form-control" id="customer_gender" value="{{ \App\Helpers\GenderHelper::getGenderText($unit_contract_request->unitDepositRequest->customer_gender) }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-6 form-group">
                            <label for="customer_phone_number">{{ __("Phone Number") }} ({{ __("1st Line") }}):</label>
                            <input type="text" class="form-control" id="customer_phone_number" value="{{ $unit_contract_request->unitDepositRequest->customer_phone_number }}" readonly="readonly">
                        </div>                     
                        <div class="col-md-6 form-group">
                            <label for="customer_phone_number2">{{ __("Phone Number") }} ({{ __("2nd Line") }}):</label>
                            <input type="text" class="form-control" id="customer_phone_number2" value="{{ $unit_contract_request->unitDepositRequest->customer_phone_number2 }}" readonly="readonly">
                        </div>                       
                    </div>
                    <h5 id="unit-information">{{ __("Unit Information") }}:</h5>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="unit_code">{{ __("Unit Code") }}:</label>
                            <input type="text" class="form-control" id="unit_code" value="{{ $unit_contract_request->unit->code }}" readonly="readonly">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="unit_type_name">{{ __("Unit Type") }}:</label>
                            <input type="text" class="form-control" id="unit_type_name" value="{{ $unit_contract_request->unit->unitType->name }}" readonly="readonly">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="project_name">{{ __("Project") }}:</label>
                            <input type="text" class="form-control" id="project_name" value="{{ $unit_contract_request->unit->unitType->project->name }}" readonly="readonly">
                        </div>
                    </div>
                    @if ( in_array(strtolower($contract_template_name), ['house','land','condo']) )
                        @include('admin.unit.partial.'.strtolower($contract_template_name), ['unit' => $unit_contract_request->unit])
                    @else
                        @include('admin.unit.partial.all', ['unit' => $unit_contract_request->unit])
                    @endif
                    <h5 id="pricing-information">{{ __("Pricing Information") }}:</h5>
                    <hr class="mt-0">  
                    <div class="row">                        
                        <div class="col-md-4 form-group">
                            <label for="unit_sale_price">{{ __("Unit Sale Price") }}:</label>
                            <input type="text" class="form-control" id="unit_sale_price" value="{{ number_format($unit_contract_request->unitDepositRequest->unit_sale_price) }}" readonly="readonly">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="discount_promotion">{{ __("Discount Promotion") }}:</label>
                            <input type="text" class="form-control" id="discount_promotion" value="{{ number_format($unit_contract_request->unitDepositRequest->discount_promotion) }}" readonly="readonly">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="other_discount_allowance">{{ __("Other Discount Allowed") }}:</label>
                            <input type="text" class="form-control" id="other_discount_allowance" value="{{ number_format($unit_contract_request->unitDepositRequest->other_discount_allowance) }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">                          
                            <label for="deposit_amount">{{ __("Deposited Amount") }}:</label>
                            <input type="text" class="form-control" id="deposit_amount" value="{{ number_format($unit_contract_request->unitDepositRequest->deposit_amount) }}" readonly="readonly">
                        </div>
                        <div class="col-md-4 form-group">                          
                            <label for="deposited_at">{{ __("Deposited At") }}:</label>
                            <input type="text" class="form-control" id="deposited_at" value="{{ $unit_contract_request->unitDepositRequest->deposited_at->toSystemDateString() }}" readonly="readonly">
                        </div>
                        <div class="col-md-4 form-group">                          
                            <label for="receiving_amount">{{ __("Received Amount") }}:</label>
                            <input type="text" class="form-control" id="receiving_amount" value="{{ number_format($unit_contract_request->unitDepositRequest->receiving_amount) }}" readonly="readonly">
                        </div>
                    </div>

                    <h5 id="payment-option">{{ __("Payment Option") }}:</h5>
                    <hr class="mt-0">     
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="payment_option">{{ __("Selected Payment Option") }}:</label>
                            <input type="text" class="form-control" id="payment_option" value="{{ empty($payment_option_array['id']) ? 'Other' : $payment_option_array['name'] }}" readonly="readonly">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="payment_day">{{ __("Start Payment Date") }}:</label>
                            <input type="text" class="form-control" id="start_payment_date" value="{{ $unit_contract_request->start_payment_date->toSystemDateString() }}" readonly="readonly">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="sign_date">{{ __("Signed At") }}:</label>
                            <input type="text" class="form-control" id="sign_date" value="{{ $unit_contract_request->signed_at->toSystemDateString() }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg form-group">
                            <label for="loan_duration">{{ __("Loan Duration") }}:</label>
                            <input type="text" id="loan_duration" class="form-control" value="{{ $payment_option_array['loan_duration'] }}" readonly="readonly" />
                        </div>
                        <div class="col-lg form-group">
                            <label for="interest">{{ __("Interest Rate") }}:</label>
                            <input type="text" id="interest" class="form-control" value="{{ $payment_option_array['interest'] }}" readonly="readonly" />
                        </div>
                        <div class="col-lg form-group">
                            <label for="special_discount">{{ __("Discount Payment Option %") }}:</label>
                            <input type="text" id="special_discount" class="form-control" value="{{ $payment_option_array['special_discount'] }}" readonly="readonly" />
                        </div>
                    </div>                   
                    <div class="row">
                        <div class="col-lg form-group">
                            <label for="is_first_payment">{{ __("Has First Payment?") }}</label>
                            <input type="text" id="is_first_payment" class="form-control" value="{{ $payment_option_array['is_first_payment'] ? 'Yes' : 'No'}}" readonly="readonly" />
                        </div>
                        <div class="col-lg form-group">
                            <label for="first_payment_duration">{{ __("First Payment Duration") }}:</label>
                            <input type="text" id="first_payment_duration" class="form-control" value="{{ $payment_option_array['first_payment_duration'] }}" readonly="readonly" />
                        </div>
                        <div class="col-lg form-group">
                            <label for="first_payment_amount">{{ isset($payment_option_array['first_payment_percentage']) ? __("First Payment Percentage") : __("First Payment Amount") }}</label>
                            <input type="text" id="first_payment_amount" class="form-control" value="{{ isset($payment_option_array['first_payment_percentage']) ? $payment_option_array['first_payment_percentage']  : $payment_option_array['first_payment_amount'] }}" readonly="readonly" />
                        </div>
                    </div> 

                    <h5 id="agent-information">{{ __("Agent Information") }}:</h5>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="remark">{{ __('Remark') }}:</label>
                            <input type="text" id="remark" class="form-control" value="{{ $unit_contract_request->remark }}" readonly="readonly" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <img src="{{ $unit_contract_request->createdBy->avatar_url }}" alt="{{ $unit_contract_request->createdBy->name }}" class="img-thumbnail">
                        </div>
                        <div class="col-md-9">
                            <div class="form-group row">
                                <label for="agent_name" class="col-sm-3 col-form-label">{{ __("Agent Name") }}:</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control" id="agent_name" value="{{ $agent->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="agent_phone_number" class="col-sm-3 col-form-label">{{ __("Phone Number") }}:</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control" id="agent_phone_number" value="{{ $agent->phone_number }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="agent_phone_number" class="col-sm-3 col-form-label">{{ __("Sale Team Leader") }}:</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control" id="agent_phone_number" value="{{ $manager ? $manager->name : 'N/A' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 id="attachment" class="mb-0">{{ __("Attachments") }}:</h5> 
                    <div class="row">      
                        @foreach( $unit_contract_request->attachments as $img )
                        <a href="{{ $img->path }}" class="thumbnail-wrapper" target="_blank">
                            <img src="{{ $img->path }}" alt="..." class="img-thumbnail img-fluid">
                        </a>
                        @endforeach
                    </div>                                                    
                </div>
                <div class="card-footer">                    
                    <div class="row">                       
                        <div class="col">
                            <a href="{{ route('admin.unit_contract_requests.index') }}" class="btn btn-secondary float-right">{{__("Back to")}} {{ __("Unit Contract Request") }} {{ __("List") }}</a>
                        </div>
                    </div>
                </div>
                </form>
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