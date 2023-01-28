@extends('layouts.app')

@section('styles')
<style type="text/css">
    .tab-pane{
        min-height: 250px;
    }

    .nav-tabs .nav-link.active {
        background-color: #fff;
    }  

    .yk-nav {
        display: flex;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    .yk-nav .nav-link {
        padding: 0.5rem 1rem 0.3rem 0; 
        color: inherit;
        font-size: 1rem;
        font-weight: bold;
    }

    .yk-nav li {
        margin-right: 1rem;
    }

    .yk-nav .nav-link.active {
        border-bottom: 2px solid #3490dc;
    }
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
        <div class="col-lg-4">
            <div class="card bg-white">
                <div class="card-body bg-secondary py-5">
                    <h3 class="text-center font-weight-bold"><span class="text-white">{{ $zone->name }}</span></h3>
                    <h6 class="text-center text-white">{{ $zone->project->name_en }}</h6>
                    @can('update-zone')
                        <a href="{{ route('admin.projects.zones.edit', ['project_id' => $zone->project->id, 'id' => $zone->id]) }}" class="position-absolute btn btn-primary btn-sm" style="top: 1rem; right: 1rem;"><i class="far fa-edit"></i></a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <ul class="yk-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Units</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Site Managers</a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection


