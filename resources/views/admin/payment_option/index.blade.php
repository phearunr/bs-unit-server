@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container" id="main-container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.payment_options.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Payment Option List") }} : <a href="{{route('admin.payment_options.create')}}" class="btn btn-primary btn-sm ">{{ __("Create New") }} {{ __("Payment Option") }}</a>
                        </div>
                        <div class="col-sm-12 col-md-auto" style="width:400px;">                           
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Name..." aria-label="Name, email or phone number" aria-describedby="button-search" name="term" value="{{ Request::query('term') ? Request::query('term') : '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" id="search-button">Search</button>
                                    <a class="btn btn-outline-secondary" data-toggle="collapse" href="#sub-header-collapse">More Filter</a>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="card-sub-header card-bg-grey collapse {{ array_except(Request::query(),'page') ? 'show' : '' }}" id="sub-header-collapse">
                    <div class="sub-header-box-wrapper">
                        <div class="form-row">
                            <div class="input-group input-group-sm col-md-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="unit_type">Unit Type</label>
                                </div>
                                <select class="form-control" name="unit_type" id="unit_type">
                                    <option value="">Choose...</option>
                                @foreach ( $projects as $project )
                                    <optgroup label="{{ $project->name }}">
                                    @foreach( $project->unitTypes as $unit_type )
                                        <option value="{{ $unit_type->id }}" 
                                                {{ $unit_type->id == Request::query('unit_type') ? "selected" : "" }} >
                                                {{ $unit_type->name }}
                                        </option>
                                    @endforeach
                                    </optgroup>
                                @endforeach
                                </select> 
                            </div>
                            <div class="input-group input-group-sm col-md-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="status">Status</label>
                                </div>                                  
                                <select class="form-control" name="status" id="status">
                                    <option value="all" {{ Request::query('status') == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="active" {{ Request::query('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="removed" {{ Request::query('status') == 'removed' ? 'selected' : '' }}>Removed</option>
                                </select>
                            </div>
                            <button class="btn btn-sm btn-primary" type="submit" id="fileter-button">Show</button>    
                            <a href="{{ route('admin.user.all') }}" class="btn btn-secondary btn-sm ml-md-2">Clear Filter</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <table class="table table-hover table-action mb-0">
                        <thead>
                            <tr>                                
                                <th scope="col">Name</th>
                                <th scope="col" width="200px">Unit Type (Project)</th>
                                <th scope="col" width="170px">Loan Option</th>
                                <th scope="col" width="130px">Created By</th>
                                <th scope="col" width="170px">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payment_options as $payment_option)
                            <tr class="{{ $payment_option->trashed() ? 'table-secondary' : '' }}">
                                <td scope="row" class="action-td">
                                    <a href="{{ route('admin.payment_options.edit',['id'=>$payment_option->id]) }}" class="title">{{ $payment_option->name }}</a>
                                    @include('admin.payment_option.action')
                                </td>
                                <td>
                                    <strong>{{ isset($payment_option->unitType) ? $payment_option->unitType->name : "N/A" }} ({{ isset($payment_option->unitType) ? $payment_option->unitType->project->name : "N/A" }})</strong>
                                </td>
                               
                                <td>
                                    <p class="mb-0">Initail Deposit: <strong>{{ number_format($payment_option->deposit_amount,2) }}</strong></p>
                                    <p class="mb-0">Duration: <strong>{{ $payment_option->loan_duration }}</strong></p>
                                    <p class="mb-0">Interest: <strong>{{ $payment_option->interest }} %</strong></p>
                                    <p class="mb-0">Special Discount: <strong>{{ $payment_option->special_discount }}%</strong></p>

                                </td>
                                <td>{{ $payment_option->createdBy->name }}</td>
                                <td>
                                    @if( $payment_option->trashed() )
                                    <ul class="mb-0 text-couple">                                       
                                        <li>
                                            <p>
                                                <small>Created At:</small>
                                                <span class="title">{{ $payment_option->created_at }}</span>
                                            </p>                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>Deleted At:</small>
                                                <span class="title">{{ $payment_option->deleted_at }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                    @else
                                    <ul class="mb-0 text-couple">                                       
                                        <li>
                                            <p>
                                                <small>Created At:</small>
                                                <span class="title">{{ $payment_option->created_at }}</span>
                                            </p>                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>Updated At:</small>
                                                <span class="title">{{ $payment_option->updated_at }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                    @endif
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
            {{ $payment_options->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection

@push("scripts")
<script type="text/javascript">
    $(document).ready(function (){
        $('.select2').select2({ theme:"bootstrap4" });
    });
</script>
@endpush

