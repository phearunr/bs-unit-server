@extends('layouts.app')

@section('styles')
<style type="text/css">   
    .lh-sm { line-height: 0.75rem; }
</style>
@endsection

@section('content')
<div class="container"> 
    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="card bg-white">
                <div class="card-body bg-secondary py-5">
                    <h3 class="text-center font-weight-bold"><span class="text-white">{{ $zone->name }}</span></h3>
                    <h6 class="text-center text-white">{{ $zone->project->name_en }}</h6>
                    @can('update-zone')
                        <a href="{{ route('project_coordinator.projects.zones.edit', ['project_id' => $zone->project->id, 'id' => $zone->id]) }}" class="position-absolute btn btn-primary btn-sm" style="top: 1rem; right: 1rem;"><i class="far fa-edit"></i></a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <ul class="yk-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ URL::current() }}">Units</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('project_coordinator.zones.site_engineers.index', ['zone_id' => $zone->id]) }}">Site Engineers</a>
                </li>
            </ul>

            <div class="row">
                <div class="col">
                @if( $units->count() == 0 )            
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-center mb-0">No unit found</h5>
                        </div>
                    </div>
                @else
                    <form>
                    <div class="input-group mb-3">
                        <input type="text" name="term" class="form-control" placeholder="Unit's Code" aria-label="Unit's Code" aria-describedby="button-find" value="{{ Request::query('term') }}">
                        <div class="input-group-append">
                            @if(Request::query('term'))
                            <a class="btn btn-outline-secondary" href="{{  URL::current() }}">Clear</a>  
                            @endif
                            <button class="btn btn-secondary" type="submit" id="button-find">Find Unit</button>
                        </div>
                    </div>
                    </form>                    
                    @foreach($units as $unit)
                    <div class="border w-100 bg-white my-3 shadow-sm">
                        <div class="d-flex pl-3 py-2">
                            <div class="align-self-center w-100 ">
                                <h5 class="mb-0 font-weight-bold">
                                    {{ $unit->code }}
                                </h5>
                                <span class="text-muted d-block">{{ $unit->unitType->name }} | {{ $unit->unitType->project->name_en }} | {{ ($unit->zone) ? $unit->zone->name : 'Unassigned Zone' }}</span>
                            </div>
                            <div class="justify-content-end align-self-center px-3">
                                <div class="btn-group">
                                    <a href="#" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="true" class="text-primary">
                                        <i class="fas fa-lg fa-ellipsis-v"></i>
                                    </a> 
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update-unit-construction')
                                        <a href="{{ route('admin.units.construction_procedures.index', ['id'=>$unit->id]) }}" class="dropdown-item">
                                            {{ __('Edit') }} {{ __("Construction Progress") }}
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex bg-light">
                            <div class="d-flex p-1 flex-column flex-fill justify-content-center align-items-center border">
                                <span class="text-muted d-block lh-sm"><small>{{ __('Availability') }}</small></span>
                                <span class="{{ $unit->action->getActionCss() }}">{{ $unit->action->action }}</span>                              
                            </div>
                            <div class="d-flex p-1 flex-column flex-fill justify-content-center align-items-center border">
                                <span class="text-muted d-block lh-sm"><small>{{ __('Progress') }}</small></span>
                                <span><strong>{{ number_format($unit->construction_overall_progress,2) * 100 }} %</strong></span>
                                
                            </div>
                            <div class="d-flex p-1 flex-column flex-fill justify-content-center align-items-center border">
                                <span class="text-muted d-block lh-sm"><small>{{ __('Priority') }}</small></span>
                                <span>coming soon</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{ $units->onEachSide(1)->appends(request()->except(['page','_token'])) }}
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


