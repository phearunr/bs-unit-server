@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.unit_actions.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Unit Action List") }}
                        </div>
                        <div class="col-sm-12 col-md-auto" style="width:400px;">                           
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Unit Code" aria-label="Unit Code" aria-describedby="button-search" name="term" value="{{ Request::query('term') ? Request::query('term') : '' }}">
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
                                       value="{{ Request::query('from') ? Request::query('from') :  \Illuminate\Support\Carbon::today()->toSystemDateString() }}"
                                >
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="to">to</label>
                                </div>                               
                                <input type="text" class="form-control datepicker" name="to" 
                                    value="{{ Request::query('to') ? Request::query('to') : \Illuminate\Support\Carbon::today()->toSystemDateString() }}"
                                >
                            </div>
                            <div class="input-group input-group-sm col-md-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="unit_type">Unit Type</label>
                                </div>
                                <select class="form-control" name="unit_type" id="unit_type">
                                    <option value="">Choose...</option>
                                @foreach ( $projects as $project )
                                    <optgroup label="{{ $project->name_en }}">
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
                                    <label class="input-group-text" for="action">Action</label>
                                </div>
                                <select class="form-control" name="action" id="action">
                                    <option value="">Choose...</option>
                                    @foreach ( $actions as $action )
                                        <option value="{{ $action }}" 
                                                {{ $action == Request::query('action') ? "selected" : "" }} >
                                                {{ $action }}
                                        </option>
                                    @endforeach
                                </select> 
                            </div>
                            <div class="col">
                                <button class="btn btn-sm btn-primary" type="submit" id="fileter-button">Show</button>
                                <a href="{{ route('admin.unit_actions.index') }}" class="btn btn-secondary btn-sm ml-md-2">Clear Filter</a>
                            </div>                            
                            
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
                                <th scope="col">Unit</th>
                                <th scope="col" width="250px">Created By</th>
                                <th scope="col" width="100px">Action</th>
                                <th scope="col" width="150px">Status</th>
                                <th scope="col" width="170px">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( $unit_actions->count() > 0 )
                                @foreach( $unit_actions AS $action )
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.units.edit',['id' => $action->unit->id]) }}" class="title">
                                                <strong>{{ $action->unit->code }}</strong>
                                            </a>                                    
                                            <span class="d-block text-muted">{{ $action->unit->unitType->name }} | {{ $action->unit->unitType->project->name_en }}</span>
                                        </td>
                                        <td>{{ $action->createdBy->name }}</td>
                                        <td><span class="{{ $action->getActionCss() }}">{{ $action->action }}</span></td>
                                        <td><span class="{{ $action->getStatusActionCss() }}">{{ $action->status_action }}</span></td>
                                        <td>
                                            <ul class="mb-0 text-couple">                                       
                                                <li>
                                                    <p>
                                                        <small>Created At:</small>
                                                        <span class="title">{{ $action->created_at }}</span>
                                                    </p>                                            
                                                </li>                                               
                                            </ul>
                                        </td>
                                      
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6"><span class="d-block text-muted text-center">There is no record for selected date.</span></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
            {{ $unit_actions->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection
