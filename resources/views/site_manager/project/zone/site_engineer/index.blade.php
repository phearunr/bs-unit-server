@extends('layouts.app')

@section('styles')
<style type="text/css">   
</style>
@endsection

@section('content')
<div class="container"> 
    @if (session('status'))
    <div class="row">
        <div class="col">
            <div class="alert alert-success alert-dismissible fade show"  role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="card bg-white">
                <div class="card-body bg-secondary py-5">
                    <h3 class="text-center font-weight-bold"><span class="text-white">{{ $zone->name }}</span></h3>
                    <h6 class="text-center text-white">{{ $zone->project->name_en }}</h6>
                    @can('update-zone')
                        <a href="{{ route('site_manager.projects.zones.edit', ['project_id' => $zone->project->id, 'id' => $zone->id]) }}" class="position-absolute btn btn-primary btn-sm" style="top: 1rem; right: 1rem;"><i class="far fa-edit"></i></a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <ul class="yk-nav">
                <li class="nav-item">
                    <a class="nav-link " href="{{  route('site_manager.zones.units.index', [ 'zone_id' => $zone->id]) }}">Units</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{URL::current()}}">Site Engineers</a>
                </li>
            </ul>

            <div class="row">
                <div class="col">
                    @each('template.site_engineers.info_card', $site_engineers, 'user', 'utils.empty')
                    {{ $site_engineers->onEachSide(1)->appends(request()->except(['page','_token'])) }}  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


