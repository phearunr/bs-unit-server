@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.unit_hold_requests.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md">
                           {{ __("Unit Hold Request List") }}
                        </div>
                        <div class="col-sm-12 col-md">                           
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Unit code..." aria-label="Unit code..." aria-describedby="button-search" name="term" value="{{ Request::query('term') ? Request::query('term') : '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" id="search-button">Search</button>
                                    <a class="btn btn-outline-secondary" data-toggle="collapse" href="#sub-header-collapse">More Filter</a>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="card-sub-header card-bg-grey collapse {{ array_except(Request::query(),'page') ? 'show' : '' }}" id="sub-header-collapse">
                    <div class="sub-header-box-wrapper pt-3">                        
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
                            <div class="input-group input-group-sm col-md-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="status">Status</label>
                                </div>                                
                                <select class="form-control" name="status" id="status">
                                    <option value="">Choose...</option>
                                    @foreach($statuses AS $status)
                                    <option value="{{ $status }}" {{ Request::query('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-sm btn-primary" type="submit" id="fileter-button">Show</button>
                                <a href="{{ route('admin.unit_hold_requests.index') }}" class="btn btn-secondary btn-sm ml-md-2">Clear Filter</a>
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
                            <tr scope="row">
                                <th scope="col" width="200px">{{ __("Unit Code") }}</th>
                                <th scope="col" width="150px">{{ __('Hold Date') }}</th>
                                <th scope="col" width="150px">{{ __("Salesperson") }}</th>
                                <th scope="col" width="150px">{{ __("Status") }}</th>
                                <th scope="col" width="30px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unit_hold_requests as $unit_hold_request)
                            <tr>
                                <td scope="row" class="action-td">
                                    <a href="{{ route('admin.units.show', ['id' => $unit_hold_request->unit_id]) }}">
                                        <strong>{{ $unit_hold_request->unit->code }}</strong>
                                    </a>
                                    <span class="d-block text-muted">
                                        {{ $unit_hold_request->unit->unitType->name }}
                                    </span>
                                    <span class="d-block text-muted">
                                        {{ $unit_hold_request->unit->unitType->project->name }} 
                                    </span>
                                </td>
                                
                                <td>
                                    {{ $unit_hold_request->created_at->toSystemDateTimeString() }}                                    
                                </td>
                                <td>
                                    <span class="d-block"><b>{{ $unit_hold_request->createdBy->name }}</b></span>
                                    <span class="d-block"><b>{{ $unit_hold_request->createdBy->phone_number }}</b></span>
                                </td>
                                <td>
                                    {!! $unit_hold_request->getStatusHtml() !!}              
                                    @if($unit_hold_request->status == 'CANCELLED' )
                                        @if( $unit_hold_request->action_reason )
                                        <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="left" title="{{ $unit_hold_request->action_reason }}"></i>
                                        @endif                                                                        
                                    <small class="d-block text-muted">{{ $unit_hold_request->actionedBy->name }}</small>
                                    <small class="d-block text-muted">{{ $unit_hold_request->actioned_at->toSystemDateTimeString() }}</small>
                                    @endif
                                   
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false"><i class="fas fa-lg fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                            <a href="#" class="dropdown-item hold-cancel-button" data-id="{{ $unit_hold_request->id }}">
                                                {{__("Cancel")}}
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
            {{ $unit_hold_requests->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
{{-- @include('admin.unit_hold_request.partials.payment_modal') --}}
@endsection


@push('scripts')
<script type="text/javascript">
    $(document).on('click','.hold-cancel-button', function (){
        var id = $(this).data('id');    
        var title = '{{ __('Please enter the reason:') }}';
        var url = `/api/unit_hold_requests/${id}/cancel`;

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
