@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" id="unit_deposit_receiving_form" action="{{ route('admin.unit_deposit_requests.update.receving_amount', ['id'=>$unit_deposit_request->id]) }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf
    <div class="row justify-content-center">       
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">       
                    {{ __("Edit Receiving Amount") }} : <strong>{{ $unit_deposit_request->unit->code }}</strong> {!! $unit_deposit_request->getStatusHtml() !!}
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
                            <label for="customer_phone_number">{{ __("Phone Number") }} ({{ __("1st Line") }}):</label>
                            <input type="text" class="form-control" id="customer_phone_number" value="{{ $unit_deposit_request->customer_phone_number }}" readonly="readonly">
                        </div>                     
                        <div class="col-md-6 form-group">
                            <label for="customer_phone_number2">{{ __("Phone Number") }} ({{ __("2nd Line") }}):</label>
                            <input type="text" class="form-control" id="customer_phone_number2" value="{{ $unit_deposit_request->customer_phone_number2 }}" readonly="readonly">
                        </div>                       
                    </div>
                    <h5 id="deposit-information">{{ __("Deposit Information") }}:</h5>
                    <hr class="mt-0">
                    <div class="row">                        
                        <div class="col-md form-group">                          
                            <label for="deposit_amount">{{ __("Deposited Amount") }}:</label>
                            <input type="text" class="form-control" id="deposit_amount" value="{{ number_format($unit_deposit_request->deposit_amount) }}" readonly="readonly">
                        </div>
                        <div class="col-md form-group">                          
                            <label for="deposited_at">{{ __("Deposited At") }}:</label>
                            <input type="text" class="form-control" id="deposited_at" value="{{ $unit_deposit_request->deposited_at->toSystemDateString() }}" readonly="readonly">
                        </div>  
                        <div class="col-md form-group">                          
                            <label for="receiving_amount">{{ __("Receiving Amount") }}:</label>
                            <input type="hidden" name="receiving_amount" value="{{ $unit_deposit_request->receiving_amount }}">
                            <input type="text" class="form-control" id="receiving_amount" value="{{ number_format( $unit_deposit_request->receiving_amount,2) }}" readonly="readonly">
                        </div>
                        <div class="col-md form-group">                          
                            <label for="receiving_amount">{{ __("Document No") }}:</label>
                            <input type="text" class="form-control" name="document_no" id="document_no" value="{{ $unit_deposit_request->document_no }}" readonly="readonly">
                            <input type="hidden" name="entry_no" id="entry_no">
                        </div>
                    </div>                 
                    <h5 id="payment-information">{{ __("Payment Information") }} ({{ __("MS NAV System") }}):</h5>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-lg">
                            <table class="table table-bordered" id="payment_table">
                                    <thead>
                                        <tr class="bg-grey">
                                            <th width="120px">{{ __('Posting Date') }}</th>                                       
                                            <th width="170px">{{ __('Type') }}</th>                           
                                            <th>{{ __('Information') }}</th>                                            
                                            <th>{{ __("Amount") }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>                                      
                                    </tbody>
                                </table>
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
    function setDeposit() {
        deposit_obj = $(this).data('deposit');          
        $('input[name="receiving_amount"]').val(Math.abs(deposit_obj.Amount));
        $('input[name="document_no"]').val(deposit_obj.Document_No);
        $('#unit_deposit_receiving_form').submit();
    }

    function buildDepositPaymentTable(payment_data) {
        var date_format = '{!! strtoupper(config("app.js_date_format")) !!}';

        $.each(payment_data, function (i, obj) { 
            var action = $('<button type="button" class="btn btn-sm btn-primary"></button')
                         .data('deposit', obj)                       
                         .html("Set as deposit");
            action.on("click", setDeposit);
            var tr = $("<tr></tr>");
            var doc_html = obj.Document_Type + " / " + obj.Payment_Type + `<br/><small>` + obj.Document_No + `</small>`;       
            var cust_html = `Customer: <b>` + obj.Customer_Name + `</b> | <b>` + obj.Customer_No + `</b><br/>
                            Unit: <b>` + obj.Item_No + `</b> | <b>` + obj.Variant_Code + `</b><br/>
                            Description: ` + obj.Description;
            var item_html = obj.Item_No + " / " + obj.Variant_Code;
            tr.append($("<td></td>").text( moment(obj.Posting_Date).format(date_format)));
            tr.append($("<td></td>").html(doc_html));
            tr.append($("<td></td>").html(cust_html));    
            tr.append($("<td></td>").html( "<b>" + $.number((obj.Amount * -1),2) + "</b>" ));
            tr.append($("<td></td>").html(action));
            $('#payment_table > tbody').append(tr);
        });
    }

    $(document).ready(function (){
        var url = '{!! route('admin.unit_deposit_requests.payment', [ 'id' => $unit_deposit_request->id ]) !!}';
        axios.get(url)
        .then(function (response) {   
            buildDepositPaymentTable(response.data.value);            
        })
        .catch(function (error) { 
            console.log(error);
        });
    });
</script>
@endpush
