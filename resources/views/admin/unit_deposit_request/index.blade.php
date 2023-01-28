    @extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.unit_deposit_requests.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md">
                           {{ __("Unit Deposit Request List") }}
                        </div>
                        <div class="col-sm-12 col-md">                           
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

                            <div class="input-group input-group-sm col-md-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="status">{{ __("Payment Status") }}</label>
                                </div>
                                <select class="form-control" name="payment_status" id="status">
                                    <option value="">Choose...</option>
                                    @foreach($payment_statuses AS $value)
                                    <option value="{{ $value }}" {{ Request::query('payment_status') == $value ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-sm btn-primary" type="submit" id="fileter-button">Show</button>
                                <a href="{{ route('admin.unit_deposit_requests.index') }}" class="btn btn-secondary btn-sm ml-md-2">Clear Filter</a>
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
                                <th scope="col" width="200px">{{ __("Customer Info.") }}</th>
                                <th scope="col" width="150px">{{ __('Deposit Date') }}</th>
                                <th scope="col">{{ __("Payment Info.") }}</th>
                                <th scope="col" width="140px">{{ __('Payment Status') }}</th>
                                <th scope="col" width="150px">{{ __("Salesperson") }}</th>
                                <th scope="col" width="30px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unit_deposit_requests as $unit_deposit_request)
                            <tr>
                                <td scope="row" class="action-td">
                                    <a href="{{ route('admin.units.show', ['id' => $unit_deposit_request->unit_id]) }}">
                                        <strong>{{ $unit_deposit_request->unit->code }}</strong>
                                    </a>
                                    <span class="d-block text-muted">
                                        {{ $unit_deposit_request->unit->unitType->name }}
                                    </span>
                                    <span class="d-block text-muted">
                                        {{ $unit_deposit_request->unit->unitType->project->name }} 
                                    </span>
                                </td>
                                <td>
                                    <span class="d-block">{{ $unit_deposit_request->customer_name}}</span>
                                    @if( $unit_deposit_request->isContainCustomer2() )
                                    <span class="d-block">{{ $unit_deposit_request->customer2_name }}</span>
                                    @endif
                                    <span class="d-block text-muted">
                                        {{ $unit_deposit_request->customer_phone_number }}
                                        {{ $unit_deposit_request->isCustomerPhoneNumber2() ? " | ". $unit_deposit_request->customer_phone_number2 : '' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $unit_deposit_request->deposited_at->toSystemDateString() }}
                                    <span class="text-muted font-italic d-block">{{ $unit_deposit_request->deposited_at->diffForHumans() }}</span>
                                </td>
                                <td>
                                    <ul class="mb-0">                    
                                        <li>{{ __("Deposit Amount") }}: <b>{{ number_format($unit_deposit_request->deposit_amount, 2)}}</b></li>
                                        <li>{{ __("Receiving Amount") }}: <b>{{ number_format($unit_deposit_request->receiving_amount, 2)}}</b></li>
                                        <li>{{ __("Due Amount") }}: <b>{{ number_format($unit_deposit_request->getDueAmount(), 2) }}</b></li>
                                    </ul>
                                </td>
                                <td>{!! $unit_deposit_request->getPaymentStatusHtml() !!}</td>
                                <td>
                                    <span class="d-block"><b>{{ $unit_deposit_request->createdBy->name }}</b></span>
                                    <span class="d-block"><b>{{ $unit_deposit_request->createdBy->phone_number }}</b></span>
                                    {!! $unit_deposit_request->getStatusHtml() !!}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false"><i class="fas fa-lg fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                            <a href="{{ route('admin.unit_deposit_requests.show', ['id' => $unit_deposit_request->id]) }}" class="dropdown-item">{{ __("View") }}</a>
                                            <a href="{{ route('admin.unit_deposit_requests.payment', [ 'id' => $unit_deposit_request->id ]) }}" data-id="{{ $unit_deposit_request->id }}" data-amount="{{ number_format($unit_deposit_request->deposit_amount,2) }}" data-date="{{ $unit_deposit_request->deposited_at->toSystemDateString() }}" data-receiving="{{ number_format($unit_deposit_request->receiving_amount,2) }}" data-document="{{ $unit_deposit_request->document_no }}" data-document="{{ $unit_deposit_request->entry_no }}" class="dropdown-item unit-deposit-request-recieve-button">{{ __("Edit Receiving Amount") }}</a>
                                        @can('cancel-unit-deposit-request')
                                            @if ( $unit_deposit_request->isCancellable() )
                                            <a href="#" class="dropdown-item unit-deposit-request-cancel-button" data-id="{{ $unit_deposit_request->id }}">
                                                {{__("Cancel")}}
                                            </a>
                                            @endif
                                        @endcan
                                        @can('void-unit-deposit-request')
                                            @if ( $unit_deposit_request->isCancellable() )
                                            <a href="#" class="dropdown-item unit-deposit-request-void-button" data-id="{{ $unit_deposit_request->id }}">
                                                {{__("Void")}}
                                            </a>
                                            @endif
                                        @endcan
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
            {{ $unit_deposit_requests->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@include('admin.unit_deposit_request.partials.payment_modal')
@endsection


@push('scripts')
<script type="text/javascript">
    $(document).on('click','.unit-deposit-request-cancel-button', function (){
        var id = $(this).data('id');    
        var title = '{{ __('Please enter the reason:') }}';
        var url = `/admin/unit_deposit_requests/${id}/cancel`;

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
                        error.response.data.message,
                        'error'
                    );
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        })
    });

    $(document).on('click','.unit-deposit-request-void-button', function (){
        var id = $(this).data('id');    
        var title = '{{ __('Please enter the reason:') }}';
        var url = `/admin/unit_deposit_requests/${id}/void`;

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
                        error.response.data.message,
                        'error'
                    );
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        })
    });
</script>
@endpush
