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
            Unit Handover Requests
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
                                <label for="term">Search :</label>
                                <input type="text" name="term" class="form-control form-control-sm" id="term" value="{{ Request::query('term') }}" placeholder="Unit Code,Status,Customer Name">
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
                            <a href="{{ route('admin.unit_handovers.index') }}" class="nav-link {{ Request::query('view') ? '' : 'active' }}">Mine</a>
                        </li> 
                        <li class="nav-item">
                            <a href="{{ route('admin.unit_handovers.index', ['view' => 'all']) }}" class="nav-link {{ Request::query('view') == 'all' ? 'active' : ''}}">All</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.unit_handovers.index', ['view' => 'pending_my_approval']) }}" class="nav-link {{ Request::query('view') == 'pending_my_approval' ? 'active' : ''}}">Need My Approval</a>
                        </li>
                    </ul>
                </div>
            </div>
            @foreach($handovers as $handover)
            <div class="d-flex border w-100 bg-white mb-2 shadow-sm align-items-stretch">
                <div class="p-2 flex-fill">
                    <a class="d-inline-block font-weight-bold">{{ $handover->Unit->code }}</a>
                    <div class="d-flex flex-md-column flex-lg-row">
                        <span class="text-muted"><i class="fas fa-user"></i> {{$handover->createdBy->name }} </span>
                        <span class="ml-lg-1 text-muted"><i class="fas fa-calendar-alt"></i> {{ $handover->created_at->toSystemDateTimeString() }} </span>
                    </div>                 
                </div>
                <div class="p-2 align-self-center w-25">
                    <span class="d-block font-weight-bold">Customer : {{$handover->customer_name}}</span>
                    <span class="d-block font-weight-bold">Relationship : {{ $handover->customer_relationship }}</span>
                </div>
                <div class="p-2 align-self-center w-25">               
                   @if(is_null($handover->approval))
                        <span class="badge badge-pill badge-secondary">{{ $handover->status }}</span></td>
                    @else
                        <span class="badge badge-pill badge-{{ is_null($handover->approval->action) ? 'info' : ($handover->approval->action ? 'success' : 'danger') }}">{{ $handover->approval->status_label }}</span>
                    @endif
                </div>
                <div class="pr-3 align-self-center">
                    <div class="btn-group show">
                        <a href="javascript::void(0)" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="true" class="text-primary"><i class="fas fa-lg fa-ellipsis-v"></i></a> 
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                            @if( Auth::user()->can('view-handover-request') )
                            <a href="{{route('admin.unit_handovers.show',['id'=>$handover->id])}}" class="dropdown-item">View</a>
                            @endif
                            @if( Auth::user()->can('update-handover-request') )
                                @if($handover->status == 'Draft')  
                                    <a href="{{route('admin.unit_handovers.edit',['id'=>$handover->id])}}" class="dropdown-item">Edit</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush


