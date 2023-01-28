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
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    {{ __("Unit Deposit Request")}} : <strong>{{ $unit_deposit_request->unit->code }}</strong> {!! $unit_deposit_request->getStatusHtml() !!}                    
                </div>              
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
                    @if( $unit_deposit_request->actioned_user_id )
                    <div class="row">
                        <div class="col-md-8 form-group">
                            <label for="actioned_user">{{ ucfirst(strtolower($unit_deposit_request->status)) }} {{ __('By') }}:</label>
                            <input type="text" class="form-control" id="actioned_user" value="{{ $unit_deposit_request->actionedBy->name }}" readonly="readonly">
                        </div>                       
                        <div class="col-md-4 form-group">
                            <label for="customer1_gender">{{ __("Actioned at") }}:</label>
                            <input type="text" class="form-control" id="customer_gender" value="{{ $unit_deposit_request->actioned_at->toSystemDateTimeString() }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="action_reason">{{ __('Reason') }}:</label>
                            <input type="text" class="form-control" id="action_reason" value="{{ $unit_deposit_request->action_reason }}" readonly="readonly">
                        </div>
                    </div>
                    @endif

                    <h5 id="customer-information">{{ __("Customer Information") }}:</h5>
                    <hr class="mt-0">
                    <div class="row">                       
                        <div class="col-md-9 form-group">
                            <label for="customer1_name">{{ __("Customer Name") }}:</label>
                            <input type="text" class="form-control" id="customer_name" value="{{ $unit_deposit_request->customer_name }}" readonly="readonly">
                        </div>                       
                        <div class="col-md-3 form-group">
                            <label for="customer1_gender">{{ __("Gender") }}:</label>
                            <input type="text" class="form-control" id="customer_gender" value="{{ \App\Helpers\GenderHelper::getGenderText($unit_deposit_request->customer_gender) }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-6 form-group">
                            <label for="customer_phone_number">{{ __("Phone Number") }} ({{ _("1st Line") }}):</label>
                            <input type="text" class="form-control" id="customer_phone_number" value="{{ $unit_deposit_request->customer_phone_number }}" readonly="readonly">
                        </div>                     
                        <div class="col-md-6 form-group">
                            <label for="customer_phone_number2">{{ __("Phone Number") }} ({{ _("2nd Line") }}):</label>
                            <input type="text" class="form-control" id="customer_phone_number2" value="{{ $unit_deposit_request->customer_phone_number2 }}" readonly="readonly">
                        </div>                       
                    </div>
                    <h5 id="unit-information">{{ __("Unit Information") }}:</h5>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="unit_code">{{ __("Unit Code") }}:</label>
                            <input type="text" class="form-control" id="unit_code" value="{{ $unit_deposit_request->unit->code }}" readonly="readonly">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="unit_type_name">{{ __("Unit Type") }}:</label>
                            <input type="text" class="form-control" id="unit_type_name" value="{{ $unit_deposit_request->unit->unitType->name }}" readonly="readonly">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="project_name">{{ __("Project") }}:</label>
                            <input type="text" class="form-control" id="project_name" value="{{ $unit_deposit_request->unit->unitType->project->name }}" readonly="readonly">
                        </div>
                    </div>
                    @if ( in_array(strtolower($contract_template_name), ['house','land','condo']) )
                        @include('admin.unit.partial.'.strtolower($contract_template_name), ['unit' => $unit_deposit_request->unit])
                    @else
                        @include('admin.unit.partial.all', ['unit' => $unit_deposit_request->unit])
                    @endif
                    <h5 id="pricing-information">{{ __("Pricing Information") }}:</h5>
                    <hr class="mt-0">  
                    <div class="row">                        
                        <div class="col-md-4 form-group">
                            <label for="unit_sale_price">{{ __("Unit Sale Price") }}:</label>
                            <input type="text" class="form-control" id="unit_sale_price" value="{{ number_format($unit_deposit_request->unit_sale_price) }}" readonly="readonly">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="discount_promotion">{{ __("Discount Promotion") }}:</label>
                            <input type="text" class="form-control" id="discount_promotion" value="{{ number_format($unit_deposit_request->discount_promotion) }}" readonly="readonly">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="other_discount_allowance">{{ __("Other Discount Allowed") }}:</label>
                            <input type="text" class="form-control" id="other_discount_allowance" value="{{ number_format($unit_deposit_request->other_discount_allowance) }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">                          
                            <label for="deposit_amount">{{ __("Deposited Amount") }}:</label>
                            <input type="text" class="form-control" id="deposit_amount" value="{{ number_format($unit_deposit_request->deposit_amount) }}" readonly="readonly">
                        </div>
                        <div class="col-md-4 form-group">                          
                            <label for="deposited_at">{{ __("Deposited At") }}:</label>
                            <input type="text" class="form-control" id="deposited_at" value="{{ $unit_deposit_request->deposited_at->toSystemDateString() }}" readonly="readonly">
                        </div>
                        <div class="col-md-4 form-group">                          
                            <label for="receiving_amount">{{ __("Receiving Amount") }}:</label>
                            <input type="text" class="form-control" id="receiving_amount" value="{{ number_format($unit_deposit_request->receiving_amount) }}" readonly="readonly">
                        </div>
                    </div>
                    <h5 id="payment-option">{{ __("Payment Option") }}:</h5>
                    <hr class="mt-0">     
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="payment_option">{{ __("Selected Payment Option") }}:</label>
                            <input type="text" class="form-control" id="payment_option" value="{{ empty($payment_option_array['id']) ? 'Other' : $payment_option_array['name'] }}" readonly="readonly">
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
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <img src="{{ $unit_deposit_request->createdBy->avatar_url }}" alt="{{ $unit_deposit_request->createdBy->name }}" class="img-thumbnail">
                        </div>
                        <div class="col-md-9">
                            <div class="form-group row">
                                <label for="agent_name" class="col-sm-3 col-form-label">{{ __("Agent Name") }}</label>
                                <div class="col-sm-9">
                                  <input type="text" readonly class="form-control" id="agent_name" value="{{ $unit_deposit_request->createdBy->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="agent_phone_number" class="col-sm-3 col-form-label">{{ __("Phone Number") }}</label>
                                <div class="col-sm-9">
                                  <input type="text" readonly class="form-control" id="agent_phone_number" value="{{ $unit_deposit_request->createdBy->phone_number }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">                    
                    <div class="row">                       
                        <div class="col">
                            <a href="{{ route('admin.unit_deposit_requests.index') }}" class="btn btn-secondary float-right">{{__("Back to")}} {{ __("Unit Deposit Request") }} {{ __("List") }}</a>
                        </div>
                    </div>
                </div>          
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function (){
        $('body').scrollspy({ target: '#scrollspy-list'});   
    });
</script>
@endpush