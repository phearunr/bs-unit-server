@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.contracts.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Contract List") }}                            
                            <!--   
                            <a href="{{ route('admin.contracts.create') }}" class="btn btn-primary btn-sm ">{{ __('Create New') }} {{ __('Contract') }}
                           </a> 
                            -->
                            <a href="{{ route('admin.contracts.export') }}" class="btn btn-primary btn-sm ">{{ __('Export') }}
                            </a> 
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
                    <div class="sub-header-box-wrapper">
                        <div class="form-row">
                            <div class="input-group input-group-sm col-md-4">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="from">Created From</label>
                                </div>   
                                <input type="text" class="form-control datepicker" name="from" 
                                       value="{{ Request::query('from') ?? '' }}"
                                >
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="to">to</label>
                                </div>                               
                                <input type="text" class="form-control datepicker" name="to" 
                                    value="{{ Request::query('to') ?? '' }}"
                                >
                            </div> 
                            <div class="input-group input-group-sm col-md-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="status">{{ __('Status') }}</label>
                                </div>                                
                                <select class="form-control" name="status" id="status">
                                    <option value="">{{ __('Choose...') }}</option>
                                    @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ Request::query('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group input-group-sm col-md-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="deadline">{{ __('Deadline') }}</label>
                                </div>                                
                                <select class="form-control" name="deadline" id="deadline">
                                    <option value="">{{ __('Choose...') }}</option>
                                    <option value="30" {{ Request::query('deadline') == 30 ? 'selected' : '' }}>Next 30 days</option>
                                    <option value="90" {{ Request::query('deadline') == 90 ? 'selected' : '' }}>Next 90 days</option>
                                    <option value="180" {{ Request::query('deadline') == 180 ? 'selected' : '' }}>Next 180 days</option>
                                    <option value="365" {{ Request::query('deadline') == 365 ? 'selected' : '' }}>Next 365 days</option>
                                </select>
                            </div>
                            <div class="col">
                                <button class="btn btn-sm btn-primary" type="submit" id="fileter-button">Show</button>
                                <a href="{{ route('admin.contracts.index') }}" class="btn btn-secondary btn-sm ml-md-2">{{ __("Clear Filter") }}</a>
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
                        <div class="alert alert-danger">
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
                                <th scope="col">{{ __('Unit Info') }}</th>                      
                                <th scope="col">{{ __('Customer Info') }}</th>
                                <th scope="col">{{ __('Agent Info') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col" width="130px">{{ __('Created By') }}</th>
                                <th scope="col" width="160px">{{ __('Timestamp') }}</th>
                                <th scope="col" width="30px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contracts as $contract)
                            <tr>
                                <td scope="row" class="action-td">
                                    <a href="{{ route('admin.units.edit', ['id' => $contract->unit_id]) }}">
                                        {{ $contract->unit->code }}
                                    </a>
                                    <small class="d-block text-muted">
                                        {{ $contract->unit->unitType->name }} 
                                        |
                                        {{ $contract->unit->unitType->project->name }} 
                                    </small>
                                    <small class="d-block">
                                        {{ __('Deadline At') }}: {{ $contract->deadline_at->toSystemDateString() }}
                                    </small>
                                    <small class="d-block">
                                        {{ __('Remaining') }}: {{ today()->diffInDays($contract->deadline_at) }} {{ str_plural('day', today()->diffInDays($contract->deadline_at)) }}
                                    </small>
                                
                                </td>
                                <td>
                                    <span class="d-block">{{ $contract->customer1_name }}
                                    @if( $contract->customer2_name != "" )
                                        | {{ $contract->customer2_name }}
                                    @endif
                                    <small class="d-block text-muted">{{ $contract->customer_phone_number }}
                                     @if( $contract->customer_phone_number2 != "" )
                                        | {{ $contract->customer_phone_number2 }}
                                    @endif
                                    </small>
                                </td>
                                <td>
                                    <ul class="mb-0">
                                        <li><b>{{ $contract->agent->name }}</b></li>
                                        <li>Phone : <b>{{ $contract->agent->phone_number }}</b></li>
                                    </ul>
                                </td>
                                <td>
                                    {!! $contract->getStatusHtml() !!}
                                    @if ($contract->actionedBy)
                                    <small class="d-block text-muted">{{ $contract->actionedBy->name }}</small>
                                    <small class="d-block text-muted">{{ $contract->actioned_at->toSystemDateTimeString() }}</small>
                                    @endif
                                </td>
                                <td><strong>{{ $contract->createdBy->name }}</strong></td>                               
                                <td>
                                    <ul class="mb-0 text-couple">
                                        <li>
                                            <p>
                                                <small>Created At:</small>
                                                <span class="title">{{ $contract->created_at->toSystemDateTimeString() }}</span>
                                            </p>
                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>Updated At:</small>
                                                <span class="title">{{ $contract->updated_at->toSystemDateTimeString() }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-lg fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('admin.contracts.edit', [ 'id' => $contract->id ] ) }}" class="dropdown-item">
                                                {{__("Edit")}}
                                            </a> 
                                            @if ( $contract->isCancellable() )
                                            <a href="#" class="dropdown-item contract-cancel-button" data-id="{{ $contract->id }}">
                                                {{__("Cancel")}}
                                            </a>
                                            @endif
                                            @can('void-contract')
                                            @if($contract->isVoidable())
                                            <a href="#" class="dropdown-item contract-void-button" data-id="{{ $contract->id }}">
                                                {{__("Void")}}
                                            </a>
                                            @endif
                                            @endcan
                                            <!--     <a href="{{ route('admin.contracts.print',[ 'id' => $contract->id ]) }}" class="dropdown-item">
                                                {{__("Print")}}
                                            </a>          -->                                  
                                            <a href="{{ route('admin.contracts.print',[ 'id' => $contract->id, 'version'=>'v2' ]) }}" class="dropdown-item">
                                                {{__("Print")}}
                                            </a>                                          
                                            <a href="{{ route('admin.contracts.upload',[ 'id' => $contract->id ]) }}" class="dropdown-item">
                                                {{__("Upload")}}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>   
                </div>
            </div>
            </form>
            {{ $contracts->appends(request()->except(['page','_token'])) }}   
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).on('click','.contract-cancel-button', function (){
        var id = $(this).data('id');        
        var title = '{{ __('Please enter the reason:') }}';
        var url = `/admin/contracts/${id}/cancel`;

        Swal.fire({
            title: title,
            input: 'textarea',       
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to write something!'
                }
            },
            showLoaderOnConfirm: true,
            preConfirm : (reason) => {
                axios.post(url, {
                    action_reason : reason,
                    _method : 'POST'
                })
                .then(function (response) {
                    if ( response.status >= 200 && response.status < 300 ) {
                        Swal.fire(
                            'Successful',
                            response.data.message,
                            'success'
                        ).then(function (){
                            location.reload();
                        });
                    } else {
                        alert(response.data.message);
                    }
                })
                .catch(function (error) {
                    Swal.fire(
                        'Error',
                        error.response.data.error.message,
                        'error'
                    );
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        })
    });

    $(document).on('click','.contract-void-button', function (){
        var id = $(this).data('id');    
        var title = '{{ __('Please enter the reason:') }}';
        var url = `/admin/contracts/${id}/void`;

        Swal.fire({
            title: title,
            input: 'textarea',       
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to give reason!'
                }
            },
            showLoaderOnConfirm: true,
            preConfirm : (reason) => {
                axios.post(url, {
                    action_reason : reason,
                    _method : 'POST'
                })
                .then(function (response) {
                    if ( response.status >= 200 && response.status < 300 ) {
                        Swal.fire(
                            'Successful',
                            response.data.message,
                            'success'
                        ).then(function (){
                            location.reload();
                        });
                    } else {
                        alert(response.data.message);
                    }
                })
                .catch(function (error) {           
                    Swal.fire(
                        'Error',
                        error.response.data.error.message,
                        'error'
                    );
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        })
    });
</script>
@endpush
