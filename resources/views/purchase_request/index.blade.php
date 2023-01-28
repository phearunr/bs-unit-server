@extends('layouts.app')

@section('styles')
<style type="text/css">
    .nav-small .nav-link {
        font-size: 0.75rem !important;
        padding-right: 8px;
    }       
</style>

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>
                Purchase Requests
                @if( Auth::user()->can('create-purchase-request') )
                <a href="{{ route('purchase_requests.create') }}" class="btn btn-sm btn-primary">New</a>
                @endif
            </h3>

            <hr>
        </div>
    </div>
    @if ($errors->any())
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif  
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    {{ __('Filter')  }}
                    <span class="float-right" data-toggle="collapse" data-target="#filter-container" aria-controls="filter-container" aria-expanded="true">
                        <i class="fas fa-angle-up"></i>
                    </span>
                </div>
                <div id="filter-container" class="collapse show">                    
                    <div class="card-body ">                        
                        <form>
                            <input type="hidden" name="view" value="{{ Request::query('view') }}">
                            <div class="form-group">
                                <label for="code">PR Code:</label>
                                <input type="text" name="code" class="form-control form-control-sm" id="code" value="{{ Request::query('code') }}" placeholder="Last number of PR Code">
                            </div>
                            <div class="form-group">
                                <label for="created_from">Created From:</label>
                                <input type="text" name="created_from" id="created_from" class="form-control form-control-sm datepicker" value="{{ Request::query('created_from') ?? '' }}">
                            </div>
                             <div class="form-group">
                                <label for="created_to">Created To:</label>
                                <input type="text" name="created_to" id="created_to" class="form-control form-control-sm datepicker" value="{{ Request::query('created_to') ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="purchase_request_project_id">Project:</label>
                                <select class="form-control form-control-sm" name="purchase_request_project_id">
                                    <option value="">All</option>
                                    @foreach($purchase_request_projects as $purchase_request_project)
                                    <option value="{{ $purchase_request_project->id }}" {{ ( Request::query('purchase_request_project_id') == $purchase_request_project->id) ? 'selected' : '' }} >{{ $purchase_request_project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="department_id">Department:</label>
                                <select class="form-control form-control-sm" name="department_id">
                                    <option value="">All</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ ( Request::query('department_id') == $department->id) ? 'selected' : '' }} >{{ $department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm float-right mb-3">Show Result</button>
                        </form>
                    </div>                 
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-8">
            <div class="row">
                <div class="col">
                    <ul class="yk-nav nav-small">
                        <li class="nav-item active">
                            <a href="{{ route('purchase_requests.index') }}" class="nav-link {{ Request::query('view') ? '' : 'active' }}">Mine</a>
                        </li> 
                        <li class="nav-item">
                            <a href="{{ route('purchase_requests.index', ['view' => 'all']) }}" class="nav-link {{ Request::query('view') == 'all' ? 'active' : ''}}">All</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('purchase_requests.index', ['view' => 'pending_my_approval']) }}" class="nav-link {{ Request::query('view') == 'pending_my_approval' ? 'active' : ''}}">Need My Approval</a>
                        </li>
                    </ul>
                </div>
            </div>

            @foreach( $purchase_requests as $purchase_request )
            <div class="d-flex border w-100 bg-white mb-2 shadow-sm align-items-stretch">
                <div class="p-2 flex-fill">
                    <a href="{{ route('purchase_requests.show', [' id' => $purchase_request->id ]) }}" class="d-inline-block font-weight-bold">{{ $purchase_request->code }}</a>
                    <div class="d-flex flex-md-column flex-lg-row">
                        <span class="text-muted"><i class="fas fa-user"></i> {{ $purchase_request->createdBy->name }} </span>
                        <span class="ml-lg-1 text-muted"><i class="fas fa-calendar-alt"></i> {{ $purchase_request->created_at->toSystemDateTimeString() }} </span>
                    </div>                 
                </div>
                <div class="p-2 align-self-center w-25">
                    <span class="d-block font-weight-bold">{{ $purchase_request->purchaseRequestProject->name }}</span>
                    <span class="d-block font-weight-bold">{{ $purchase_request->department->name }}</span>
                </div>
                <div class="p-2 align-self-center w-25">
                    @if(is_null($purchase_request->approval))
                        <span class="badge badge-pill badge-secondary">{{ $purchase_request->status }}</span></td>
                    @else
                        <span class="badge badge-pill badge-{{ is_null($purchase_request->approval->action) ? 'info' : ($purchase_request->approval->action ? 'success' : 'danger') }}">{{ $purchase_request->approval->status_label }}</span>
                    @endif
                </div>
                <div class="pr-3 align-self-center">
                    <div class="btn-group show">
                        <a href="javascript::void(0)" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="true" class="text-primary"><i class="fas fa-lg fa-ellipsis-v"></i></a> 
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                            <a href="{{ route('purchase_requests.show', [ 'id' => $purchase_request->id]) }}" class="dropdown-item">View</a>
                            @if( $purchase_request->status == 'Draft' AND $purchase_request->user_id == Auth::id() ) 
                            <a href="{{ route('purchase_requests.edit', [ 'id' => $purchase_request->id]) }}" class="dropdown-item">Edit</a>
                            @endif
                            @if( $purchase_request->approval AND $purchase_request->approval->action AND is_null($purchase_request->approval->next_approval_id) )
                            <a href="{{ route('purchase_requests.print', [ 'id' => $purchase_request->id ]) }}" class="dropdown-item">Print</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{ $purchase_requests->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('.input-daterange input').each(function() {
        $(this).datepicker('clearDates');
    });
</script>
@endpush