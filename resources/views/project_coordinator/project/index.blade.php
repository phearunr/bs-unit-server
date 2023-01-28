@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center"> 
        <div class="col-lg-3">
            <form method="GET" action="{{ route('project_coordinator.projects.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false" class="position-sticky sticky-top-offset-1">
            <div class="card mb-3">         
                <div class="card-header">
                    {{ __('Filter')  }}
                    <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#filter-container" aria-controls="filter-container" aria-expanded="true">
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <div id="filter-container" class="collapse show">
                    <article class="card-group-item">
                        <div class="filter-content">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12"> 
                                        <label>{{ __('Search')}}</label>                                      
                                        <input type="text" class="form-control" placeholder="Name, Short Code ..." aria-label="Name, email or phone number" aria-describedby="button-search" name="term" value="{{ Request::query('term') ? Request::query('term') : '' }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>{{ ('Company')}}</label>
                                        <select class="form-control" name="company" id="company">
                                            <option value="" {{Request::query('company') == '' ? 'selected' : ''}}>{{ ('All') }}</option>
                                            @foreach ($companies as $company)       
                                            <option value="{{ $company->id }}" {{ (Request::query('company') == $company->id) ? 'selected': '' }}>{{ $company->name_en}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12"> 
                                        <label>{{ __('Published')}}</label>               
                                        <select class="form-control" name="status" id="status">
                                            <option value="all" {{Request::query('status') == 'all' ? 'selected' : ''}}>{{ __('All') }}</option>
                                            <option value="active" {{Request::query('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                            <option value="removed" {{Request::query('status') == 'removed' ? 'selected' : ''}}>{{ __('Removed') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12"> 
                                        <button type="submit" class="btn btn-primary btn-sm float-right">{{ __('Show Result') }}</button>
                                    </div>
                                </div>
                            </div> <!-- card-body.// -->
                        </div>
                    </article>
                </div>
                
            </div>
            </form>
        </div>
        <div class="col-lg-9">
            <div class="row">
                @foreach($projects as $project) 
                <div class="col-lg-12 mb-3">
                    <div class="item-container">
                        <div class="item-feature-image"><img class="d-flex flex-row" src="{{ $project->feature_image_url }}" alt="Card image cap"></div>
                        <div class="item-content position-relative">
                            <div class="item-body">
                                <h5><a href="{{ route('project_coordinator.projects.show', ['id' => $project->id]) }}">{{ $project->name }}</a></h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $project->name_en }}</h6>
                                <ul class="list-inline pl-0 mb-0">
                                    <li class="list-inline-item"><i class="fas fa-hashtag"></i> {{ $project->short_code }}</li>
                                    <li class="list-inline-item"><i class="fas fa-map-marked-alt"></i> {{ $project->address }}</li>                               
                                    <li class="list-inline-item">{!! $project->getPublishedHtmlStatus() !!} {{ $project->is_published ? 'Active' : 'Removed'}}</li>
                                </ul>
                                
                            </div>
                            <div class="item-footer">                               
                                <small class="text-muted"><i class="far fa-clock"></i> Last updated: {{ $project->updated_at->diffForHumans() }} <i class="fas fa-user-alt"></i> Updated by: {{ $project->createdBy->name }}</small>
                            </div>

                            <div class="btn-group btn-group-action-absolute">
                                <a href="#" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="true" class="text-primary"><i class="fas fa-lg fa-ellipsis-v"></i></a> 
                                <div class="dropdown-menu dropdown-menu-right">
                                  
                                    @can('view-master-plan-project')
                                    <a href="{{ route('project_coordinator.projects.master_plan', [ 'id' => $project->id]) }}" class="dropdown-item">{{ __("View Master Plan") }}</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>                  
                </div>
                @endforeach
            </div>
            {{ $projects->appends(request()->except(['page','_token'])) }}  
        </div>
    </div>
</div>
@endsection
