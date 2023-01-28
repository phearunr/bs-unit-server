@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.unit_contract_requests.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Unit Contract Request List") }}
                        </div>
                        <div class="col-sm-12 col-md-auto" style="width:400px;">                           
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Name, phone, unit code..." aria-label="Name, phone, unit code..." aria-describedby="button-search" name="term" value="{{ Request::query('term') ? Request::query('term') : '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" id="search-button">Search</button>
                                    <a class="btn btn-outline-secondary" data-toggle="collapse" href="#sub-header-collapse">More Filter</a>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="card-sub-header card-bg-grey collapse {{ array_except(Request::query(),'page') ? 'show' : '' }}" id="sub-header-collapse">
                    <div class="sub-header-box-wrapper pt-2">
                        <div class="form-row">
                            <div class="input-group input-group-sm col-lg-4">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="status">Date:</label>
                                </div>
                                <input type="text" class="form-control datepicker" name="from" 
                                           value="{{ Request::query('from') ? Request::query('from') : '' }}"
                                    >
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="to">to</label>
                                </div>                               
                                <input type="text" class="form-control datepicker" name="to" 
                                    value="{{ Request::query('to') ? Request::query('to') : '' }}"
                                >
                            </div>
                            <button class="btn btn-sm btn-primary" type="submit" id="fileter-button">Show</button>
                                <a href="{{ route('admin.unit_contract_requests.index') }}" class="btn btn-secondary btn-sm ml-md-2">Clear Filter</a>
                        </div>
                    </div>
                </div>    
                <div class="card-body p-0">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger mb-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th scope="col" width="200px">Unit Code</th>
                                <th scope="col" width="220px">Customer Info.</th>
                                <th scope="col">Payment Info.</th>                               
                                <th scope="col" width="100px">Status</th>                  
                                <th scope="col" width="170px">Timestamp</th>
                                <th scope="col" width="50px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unit_contract_requests as $unit_contract_request)
                            <tr>
                                <td scope="row" class="action-td">
                                    <a href="{{ route('admin.units.show', ['id' => $unit_contract_request->unit_id]) }}">
                                        {{ $unit_contract_request->unit->code }}
                                    </a>
                                    <span class="d-block text-muted">
                                        {{ $unit_contract_request->unit->unitType->name }} 
                                        |
                                        {{ $unit_contract_request->unit->unitType->project->name }} 
                                    </span>
                                </td>
                                <td>
                                    <span class="d-block">{{ $unit_contract_request->unitDepositRequest->customer_name}}</span>
                                    <span class="d-block text-muted">                                         
                                        {{ $unit_contract_request->unitDepositRequest->customer_phone_number }}
                                        {{ $unit_contract_request->unitDepositRequest->isCustomerPhoneNumber2() ? " | ". $unit_contract_request->unitDepositRequest->customer_phone_number2 : '' }}
                                    </span>
                                </td>
                                <td>
                                    <ul class="mb-0">
                                        <li>Unit Sold Price : <b>{{ number_format($unit_contract_request->unitDepositRequest->unit_sale_price,2)}}</b></li>
                                        <li>Deposit Amount: <b>{{ number_format($unit_contract_request->unitDepositRequest->deposit_amount,2)}}</b></li>
                                        <li>
                                            Payment Option : 
                                            @if (is_null($unit_contract_request->unitDepositRequest->payment_option_id))
                                                <b>Other</b>
                                            @else
                                                <a href="{{ route('admin.unit_types.edit', ['id' => $unit_contract_request->unitDepositRequest->payment_option_id]) }}">
                                                    <b>{{ $unit_contract_request->unitDepositRequest->paymentOption->name }}</b>
                                                </a>
                                            @endif                                         
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    {!! $unit_contract_request->getStatusHtml() !!}
                                </td>
                                <td>
                                    <ul class="mb-0 text-couple">                                       
                                        <li>
                                            <p>
                                                <small>Created At:</small>
                                                <span class="title">{{ $unit_contract_request->created_at->toSystemDateTimeString() }}</span>
                                            </p>                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>Updated At:</small>
                                                <span class="title">{{ $unit_contract_request->updated_at->toSystemDateTimeString() }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <a href="{{ route('admin.unit_contract_requests.show',['id' => $unit_contract_request->id]) }}" class="text-primary">
                                        <i class="far fa-lg fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"></i>                                       
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>   
                </div>
            </div>
            </form>    
            {{ $unit_contract_requests->appends(request()->except(['page','_token'])) }}           
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush
