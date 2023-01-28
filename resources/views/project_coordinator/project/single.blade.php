@extends('layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/flickity.min.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-3">
                <img class="card-img-top" src="{{ $project->feature_image_url }}" alt="Card image cap">
                <div class="card-body position-relative">
                    <h5><a href="{{ route('project_coordinator.projects.show', ['id' => $project->id]) }}">{{ $project->name }}</a></h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $project->name_en }}</h6>
                    <ul class="list-unstyled pl-0 mb-0">
                        <li class="list-inline-item">{!! $project->getPublishedHtmlStatus() !!} {{ $project->is_published ? 'Active' : 'Removed'}}</li>
                        <li><i class="fas fa-hashtag"></i> {{ $project->short_code }}</li>
                        <li><i class="fas fa-map-marked-alt"></i> {{ $project->address }}</li>
                    </ul>
                    <div class="btn-group btn-group-action-absolute">
                        <a href="#" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="true" class="text-primary"><i class="fas fa-lg fa-ellipsis-v"></i></a> 
                        <div class="dropdown-menu dropdown-menu-right">
                            @can('update-project')
                            <a href="{{ route('project_coordinator.projects.edit', [ 'id' => $project->id]) }}" class="dropdown-item">{{ __("Edit") }}</a>
                            @endcan

                            @can('view-master-plan-project')
                            <a href="{{ route('project_coordinator.projects.master_plan', [ 'id' => $project->id]) }}" class="dropdown-item">{{ __("View Master Plan") }}</a>
                            @endcan
                        </div>
                    </div>
                </div>    
                <ul class="list-group list-group-flush">
                     <li class="list-group-item">
                        <small class="text-muted d-block">{{ __("Company") }}</small>    
                        <span class="d-block font-weight-bold">{{  $project->company->name_km }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">{{ __('Sale Representative') }}</small>    
                        <span class="d-block font-weight-bold">{{ $project->saleRepresentative->name }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">{{ __('Bank') }}</small>    
                        <span class="d-block font-weight-bold">[{{ $project->bank->short_name }}] - {{ $project->bank->account_name }} - {{ $project->bank->account_number }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">{{ __("Dynamic NAV Company Code") }}</small>    
                        <span class="d-block font-weight-bold">{{  $project->nav_company_code }}</span>
                    </li>                   
                </ul>
                <div class="card-footer">
                    <small class="text-muted"><i class="far fa-clock"></i> Last updated: {{ $project->updated_at->diffForHumans() }} <i class="fas fa-user-alt"></i> Updated by: {{ $project->createdBy->name }}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-column bg-white border">
                        <div class="text-center bg-primary p-3 ">
                            <a href="{{ route('project_coordinator.projects.units.index', ['project_id' => $project->id]) }}" class="font-weight-bold display-4 d-block text-white">{{ $project->units_count ?? 'N/A' }}</a>
                            <small class="text-white">{{ __('Total Units') }}</small>
                        </div>
                        <div class="d-flex flex-column flex-sm-row">
                            <div class="flex-fill p-3 text-center border bg-grey">
                                <h4 class="mb-0 font-weight-bold"><a href="{{ route('project_coordinator.projects.units.index', ['project_id' => $project->id, 'status' => 'AVAILABLE']) }}">{{ $project->available_unit_count ?? 'N/A' }}</a></h4>
                                <small class="text-muted">{{ __('Available') }}</small>
                            </div>
                            <div class="flex-fill p-3 text-center border bg-grey">
                                <h4 class="mb-0 font-weight-bold"><a href="{{ route('project_coordinator.projects.units.index', ['project_id' => $project->id, 'status' => 'UNAVAILABLE']) }}">{{ $project->unavailable_unit_count ?? 'N/A' }}</a></h4>
                                <small class="text-muted">{{ __('Unavailable') }}</small>
                            </div>
                            <div class="flex-fill p-3 text-center border bg-grey">
                                <h4 class="mb-0 font-weight-bold"><a href="{{ route('project_coordinator.projects.units.index', ['project_id' => $project->id, 'status' => 'HOLD']) }}">{{ $project->hold_unit_count ?? 'N/A' }}</a></h4>
                                <small class="text-muted">{{ __('Hold') }}</small>
                            </div>
                            <div class="flex-fill p-3 text-center border bg-grey">
                                <h4 class="mb-0 font-weight-bold"><a href="{{ route('project_coordinator.projects.units.index', ['project_id' => $project->id, 'status' => 'DEPOSTI']) }}">{{ $project->deposit_unit_count ?? 'N/A' }}</a></h4>
                                <small class="text-muted">{{ __('Deposit') }}</small>
                            </div>
                            <div class="flex-fill p-3 text-center border bg-grey">
                                <h4 class="mb-0 font-weight-bold"><a href="{{ route('project_coordinator.projects.units.index', ['project_id' => $project->id, 'status' => 'CONTRACT']) }}">{{ $project->contract_unit_count ?? 'N/A' }}</a></h4>
                                <small class="text-muted">{{ __('Contract') }}</small>
                            </div>
                            <div class="flex-fill p-3 text-center border bg-grey">
                                <h4 class="mb-0 font-weight-bold"><a href="{{ route('project_coordinator.projects.units.index', ['project_id' => $project->id, 'status' => 'HANDOVERED']) }}">{{ $project->handovered_unit_count ?? 'N/A' }}</a></h4>
                                <small class="text-muted">{{ __('Handovered') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex mt-4 mb-2">
                <h5>{{ __('Unit Types') }} - ({{ count($project->unitTypes) }})</h5>
                @can('create-unit-type')
                <a href="{{ route('admin.unit_types.create') }}" class="btn btn-primary btn-sm align-self-center ml-auto">New Unit Type</a>
                @endcan
            </div>
         
            @if( $project->unitTypes->count() == 0)            
            <div class="card">
                <div class="card-body d-flex justify-content-center" style="height: 250px;">
                    <h5 class="align-self-center ">{{ __("No Unit type available for this project") }}</h5>
                </div>
            </div>
            @else
                @include('template.unit_types.carousel', ['unit_types' => $project->unitTypes, 'route_prefix' => 'project_coordinator'])
            @endif
                         
            <div class="d-flex mt-4 mb-2 New Unit type">
                <h5 class="">Zones - ({{ count($project->zones) }})</h5>
                @can('create-zone')
                <a href="{{ route('site_manager.projects.zones.create', [ 'project_id' => $project->id ]) }}" class="btn btn-primary btn-sm align-self-center ml-auto">New Zone</a>
                @endcan
            </div>

            <div class="d-flex rounded bg-secondary pt-2 px-3 mb-3" style="color:#fff;">
                <h5 class="flex-fill">Total Progress Average</h5>
                <h5><strong>{{ number_format($project->progress_average, 2) * 100  }} %</strong></h5>
            </div>

            @if( $project->zones->count() == 0 )
                <div class="card">
                    <div class="card-body d-flex flex-column justify-content-center" style="height: 250px;">
                        <h5 class="align-self-center">{{ __("No Zone available for this project") }}</h5>
                        @can('create-zone')
                        <a href="{{ route('admin.projects.zones.create', [ 'project_id' => $project->id ]) }}" class="btn btn-primary align-self-center btn-sm">Click here to create new zone</a>
                        @endcan
                    </div>
                </div>
            @else
                @include('template.zones.carousel', ['zones' => $project->zones, 'route_prefix' => 'project_coordinator'])
            @endif                   
        </div>
    </div>
</div>
@endsection

@push("scripts")
<script type="text/javascript" src="{{ asset('js/flickity.pkgd.min.js') }}" ></script>
<script type="text/javascript">  
$('.main-carousel').flickity({
    cellAlign: 'left',
    contain: true,
    pageDots: false
});
</script>
@endpush
