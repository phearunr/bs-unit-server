@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container" id="main-container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('contracts.template') }}" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Contract Template") }}
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
                            <a href="{{ route('contracts.template') }}" class="btn btn-secondary btn-sm ml-md-2">Clear Filter</a>
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
                                <th scope="col">{{ __('Unit Type Name') }}</th>
                                <th width="150px">{{ __('Template Type') }}</th>
                                <th width="230px">{{ __('Project') }}</th>
                                <th width="200px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unit_types as $unit_type)
                            <tr class="{{ $unit_type->trashed() ? 'table-secondary' : '' }}">
                                <td scope="row">
                                    <strong>{{ $unit_type->name }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $unit_type->contractTemplate->name }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $unit_type->project->name_en }}</strong>
                                </td>
                                <td>
                                    <a href="{{ route('admin.contract_templates.preview',['template_path' => $unit_type->contractTemplate->template_path, 'unit_type_id' => $unit_type->id]) }}" data-toggle="tooltip" data-placement="bottom" title="Click to view contract template" class="btn btn-primary btn-sm" target="_blank">{{ __('View') }}</a>
                                    <a href="{{ route('admin.contract_templates.preview',['template_path' => $unit_type->contractTemplate->template_path, 'unit_type_id' => $unit_type->id, 'version' => 'v2' ]) }}" data-toggle="tooltip" data-placement="bottom" title="Click to view contract template version 2" class="btn btn-primary btn-sm" target="_blank">{{ __('View V2') }}</a>
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
