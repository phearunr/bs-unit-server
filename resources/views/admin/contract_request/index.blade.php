@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.contract_request.all') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Contract Request List") }}
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
                            <div class="form-group col-lg">
                                <label for="from" class="mb-0"><small>Date:</small></label>
                                <div class="input-group input-group-sm">                                
                                    <input type="text" class="form-control datepicker" name="from" 
                                           value="{{ Request::query('from') ? Request::query('from') :  \Carbon\Carbon::today()->firstOfMonth()->toDateString() }}"
                                    >
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="to">to</label>
                                    </div>                               
                                    <input type="text" class="form-control datepicker" name="to" 
                                        value="{{ Request::query('to') ? Request::query('to') : \Carbon\Carbon::today()->lastOfMonth()->toDateString() }}"
                                    >
                                </div>
                            </div>
                            <div class="form-group col-lg">
                                <label for="created_by" class="mb-0"><small>Created By:</small></label>
                                <select class="form-control form-control-sm" name="created_by" id="created_by">
                                    <option value="all" {{ Request::query('uc_status') == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="pending" {{ Request::query('uc_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ Request::query('uc_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ Request::query('uc_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="form-group col-lg">
                                <label for="uc_status" class="mb-0"><small>Unit Controller Status:</small></label>
                                <select class="form-control form-control-sm" name="uc_status" id="uc_status">
                                    <option value="all" {{ Request::query('uc_status') == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="pending" {{ Request::query('uc_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ Request::query('uc_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ Request::query('uc_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="form-group col-lg">
                                <label for="uc_status" class="mb-0"><small>Sale Manager Status:</small></label>
                                <select class="form-control form-control-sm" name="sm_status" id="sm_status">
                                    <option value="all" {{ Request::query('sm_status') == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="pending" {{ Request::query('sm_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ Request::query('sm_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ Request::query('sm_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">                        
                                <button class="btn btn-sm btn-primary" type="submit" id="fileter-button">Show</button>
                                <a href="{{ route('admin.contract_request.all') }}" class="btn btn-secondary btn-sm ml-md-2">Clear Filter</a>
                            </div>     
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
                                <th scope="col">Information</th>
                                <th scope="col" width="150px">Created By</th> 
                                <th scope="col" width="250px">Approval</th>                  
                                <th scope="col" width="170px">Timestamp</th>
                                <th scope="col" width="50px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contract_requests as $contract_request)
                            <tr>
                                <td>
                                    <ul class="mb-0">
                                        <li>Customer 1: <b>{{ $contract_request->customer1_name }} {{ $contract_request->customer1_gender == 1 ? "(Male)" : "(Female)" }}</b></li>
                                        <li>Customer 2: 
                                            @if( $contract_request->customer2_name == "" )
                                                <b>N/A : (N/A)</b>
                                            @else
                                                <b>{{ $contract_request->customer2_name }} {{ $contract_request->customer2_gender == 1 ? "(Male)" : "(Female)" }}</b>
                                            @endif
                                        </li>
                                        <li>Customer Phone: <b>{{ $contract_request->customer_phone_number }}, {{ $contract_request->customer_phone_number2 }}</b></li>
                                        <li>Agent Name: <b>{{ $contract_request->agent_name }} {{ $contract_request->agent_gender == 1 ? "(Male)" : "(Female)" }}</b></li>
                                        <li>Unit Code: <b>{{ $contract_request->unit->code }}</b></li>
                                    </ul>
                                </td>
                                <td><strong>{{ $contract_request->createdBy->name }}</strong></td>
                                <td>
                                    <ul>
                                        <li>Unit Controller : <span class="font-weight-bold {{ $contract_request->getUnitControllerStatusCssTextStyle() }}">{{ $contract_request->unit_controller_status }}</span></li>
                                        <li>Sale Manager : <span class="font-weight-bold {{ $contract_request->getSaleManagerStatusCssTextStyle() }}">{{ $contract_request->sale_manager_status }}</span></li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="mb-0 text-couple">
                                        <li>
                                            <p>
                                                <small>Created At:</small>
                                                <span class="title">{{ $contract_request->created_at }}</span>
                                            </p>
                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>Updated At:</small>
                                                <span class="title">{{ $contract_request->updated_at }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <a href="{{ route('admin.contract_request.show', [ 'id' => $contract_request->id ] ) }}" class="text-primary">
                                        <i class="fas fa-lg fa-ellipsis-v"></i>
                                    </a>
                                    @if( $contract_request->allowCreateContract() )
                                    <a href="{{ route('admin.contracts.create', [ 'reference' => $contract_request->id ] ) }}" class="text-primary">
                                        <i class="material-icons" data-toggle="tooltip" data-placement="top" title="Convert to Contract">picture_as_pdf</i>
                                    </a>
                                    @endif
                                </td>                              
                            </tr>
                            @endforeach
                        </tbody>
                    </table>   
                </div>
            </div>
            </form>
            {{ $contract_requests->appends(request()->except(['page','_token'])) }}   
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush
