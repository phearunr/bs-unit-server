@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container" id="main-container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.unit_types.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Unit Type List") }} : <a href="{{route('admin.unit_types.create')}}" class="btn btn-primary btn-sm ">{{ __("Create New") }} {{ __("Unit Type") }}</a>
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
                                    <label class="input-group-text" for="project_select">Project</label>
                                </div>
                                <select class="form-control" name="project" id="project_select">
                                    <option value="">Choose...</option>
                                    @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ Request::query('project') == $project->id ? 'selected' : '' }}>{{ $project->name_en }}</option>
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
                            <a href="{{ route('admin.unit_types.index') }}" class="btn btn-secondary btn-sm ml-md-2">Clear Filter</a>
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
                                <td width="100">No. Unit</td>
                                <th width="150px">Payment Options</th>
                                <th width="230px">Project</th>
                                <th width="130px">Created By</th>
                                <th width="170px">Timestamp</th>
                                <th width="30px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unit_types as $unit_type)
                            <tr class="{{ $unit_type->trashed() ? 'table-secondary' : '' }}">
                                <td scope="row" class="action-td">
                                    <a href="{{ route('admin.unit_types.edit',['id'=>$unit_type->id]) }}" class="title">{{ $unit_type->name }}</a>
                                    @if(!$unit_type->activeDiscountPromotions->isEmpty())
                                        <small class="d-block">
                                            <i class="fas fa-circle text-success"></i> {{ __('Promotion') }} : 
                                            $ {{ number_format($unit_type->activeDiscountPromotions[0]['amount'], 2) }}
                                        </small>
                                        <small class="d-block">
                                            <i class="far fa-calendar-alt"></i> ({{ $unit_type->activeDiscountPromotions[0]['start_date']->toSystemDateString() }} - {{ $unit_type->activeDiscountPromotions[0]['end_date']->toSystemDateString() }})
                                        </small>                              
                                    @endif
                                       
                                   <!--  @include('admin.unit_type.action') -->
                                </td>
                                <td>
                                    <a href="{{ route('admin.units.index', ['unit_type' => $unit_type->id]) }}">
                                        <strong>{{ $count = $unit_type->units_count }} {{ str_plural('Unit',$count) }}</strong> 
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.payment_options.index', ['unit_type' => $unit_type->id]) }}">
                                        <strong>{{ $count = $unit_type->payment_options_count }} {{ str_plural('Option', $count) }}</strong> 
                                    </a>
                                </td>
                                <td>
                                    <strong>{{ $unit_type->project->name_en }}</strong>
                                </td>
                                <td>{{ $unit_type->createdBy->name }}</td>
                                <td>
                                    @if( $unit_type->trashed() )
                                    <ul class="mb-0 text-couple">                                       
                                        <li>
                                            <p>
                                                <small>Created At:</small>
                                                <span class="title">{{ $unit_type->created_at }}</span>
                                            </p>                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>Deleted At:</small>
                                                <span class="title">{{ $unit_type->deleted_at }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                    @else
                                    <ul class="mb-0 text-couple">                                       
                                        <li>
                                            <p>
                                                <small>Created At:</small>
                                                <span class="title">{{ $unit_type->created_at }}</span>
                                            </p>                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>Updated At:</small>
                                                <span class="title">{{ $unit_type->updated_at }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-lg fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="dropdownMenuButton">
                                            @if($unit_type->trashed())
                                                <a href="{{ route('admin.unit_types.restore',['id'=>$unit_type->id]) }}" class="dropdown-item">
                                                    {{__("Restore")}} {{ __("Unit Type") }}
                                                </a>                                                 
                                            @else
                                                <a href="{{ route('admin.unit_types.edit',['id'=>$unit_type->id]) }}" class="dropdown-item">
                                                    {{__("Edit")}} {{ __("Unit Type") }}
                                                </a> 
                                                <a href="{{ route('admin.unit_types.clone',['id'=>$unit_type->id]) }}" class="dropdown-item">
                                                    {{__("Clone")}} {{ __("Payment Options") }}
                                                </a>                                                                                              
                                                <a href="{{ route('admin.unit_types.delete',['id'=>$unit_type->id]) }}" class="dropdown-item">
                                                    {{__("Remove")}} {{ __("Unit Type") }}
                                                </a>
                                                <a href="{{ route('admin.unit_types.set_saleable_status',['id'=>$unit_type->id]) }}" class="dropdown-item">
                                                    {{ __("Set Units' Saleable Status")}}
                                                </a>                                              
                                            @endif
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
            {{ $unit_types->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection
