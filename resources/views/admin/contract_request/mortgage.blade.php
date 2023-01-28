@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.projects.store') }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf        
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{__("Payment Schedule")}} : <strong>{{ $contract_request->customer1_name }} ({{ $contract_request->unit_code }})</strong></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <h5>Payment Information</h5>
                                <hr class="mt-0">
                                <table class="table-couple">
                                    <tr>
                                        <td class="title" width="200px">Sold Price:</td>    
                                        <td class="text">{{ number_format($contract_request->unit_sold_price,2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Discount Promotion:</td>    
                                        <td class="text">{{ number_format($contract_request->discount_promotion,2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Other Dis. Allowance:</td>
                                        <td class="text">{{ number_format($contract_request->other_discount_allowed,2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Price After discount:</td>
                                        <td class="text bg-grey">{{ number_format($contract_request->getUnitSoldPriceAfterDiscount(),2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Discount Payment Option:</td>
                                        <td class="text">{{ number_format($contract_request->getDiscountAmountByPaymentOption(),2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Final Price:</td>
                                        <td class="text bg-grey">{{ number_format($contract_request->getUnitSoldPriceAfterAllDiscount(),2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Deposited Amount:</td>
                                        <td class="text bg-grey">{{ number_format($contract_request->deposited_amount,2) }} ({{ $contract_request->deposited_date->toDateString() }})</td>
                                    </tr>                                   
                                  
                                    <tr>
                                        <td class="title">Start Date of Payment:</td>                                        
                                        <td class="text bg-grey">{{ $contract_request->payment_day }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-7">
                                <h5>Selected Payment Option</h5>
                                <hr class="mt-0">
                                <table class="table-couple">
                                    <tr>                                          
                                        <td class="text" colspan="2">{{ $payment_option->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title" width="180px">Loan Duration (Month):</td>    
                                        <td class="text">{{ $payment_option->loan_duration }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Interest Rate (%):</td>
                                        <td class="text">{{ $payment_option->interest }}</td>
                                    </tr>                                  
                                    <tr>
                                        <td class="title">Special Discount (%):</td>
                                        <td class="text">{{ $payment_option->special_discount }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Have First Payment?:</td>
                                        <td class="text">{{ $payment_option->is_first_payment ? "Yes" : "No"}}</td>
                                    </tr>
                                    @if( $payment_option->is_first_payment )
                                    <tr>
                                        <td class="title">Duration (Month):</td>
                                        <td class="text">{{ $payment_option->first_payment_duration }}</td>
                                    </tr>                                   
                                    <tr>
                                        <td class="title">Percentage (%):</td>
                                        <td class="text">{{ $payment_option->first_payment_percentage }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Amount Per Month:</td>
                                        <td class="text">{{ number_format($contract_request->getFirstPaymentAmountPerMonth(),2) }} ({{ number_format($contract_request->getFirstPaymentTotalAmount(),2) }})</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pt-3">
                                <h5>Payment Schedule</h5>
                                <hr class="mt-0">
                                @if( $payment_option->is_first_payment )                                
                                <table class="table table-bordered">
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
                                        <tbody>
                                            @foreach( $contract_request->firstPaymentCollection() as $obj )
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $obj['payment_date'] }}</td>
                                                <td>{{ number_format($obj['beginning_balance'],2) }}</td>
                                                <td>{{ number_format($obj['amount_to_pay'],2) }}</td>
                                                <td>{{ number_format($obj['ending_balance'],2) }}</td>
                                                <th>{!! $obj['note'] !!}</th>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </tbody>
                                </table>
                                @endif
                                <table class="table table-bordered">
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
                                        <tbody>
                                            @foreach( $contract_request->loanPaymentCollection() as $obj )
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $obj['payment_date'] }}</td>
                                                <td>{{ number_format($obj['beginning_balance'],2) }}</td>
                                                <td>{{ number_format($obj['monthly_payment'],2) }}</td>
                                                <td>{{ number_format($obj['principle'],2) }}</td>
                                                <td>{{ number_format($obj['interest'],2) }}</td>
                                                <td>{{ number_format($obj['ending_balance'],2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
