@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA==" crossorigin="anonymous" />
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
                        <a href="{{ route('admin.projects.zones.edit', ['project_id' => $zone->project->id, 'id' => $zone->id]) }}" class="position-absolute btn btn-primary btn-sm" style="top: 1rem; right: 1rem;"><i class="far fa-edit"></i></a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <ul class="yk-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.zones.units.index', ['zone_id' => $zone->id]) }}">Units</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ URL::current() }}">Site Engineers</a>
                </li>
            </ul>

            <div class="row">
                <div class="col">               
                    @each('template.site_engineers.info_card', $users, 'user', 'utils.empty')
                    {{ $users->onEachSide(1)->appends(request()->except(['page','_token'])) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js" integrity="sha512-k2GFCTbp9rQU412BStrcD/rlwv1PYec9SNrkbQlo6RZCf75l6KcC3UwDY8H5n5hl4v77IDtIPwOk9Dqjs/mMBQ==" crossorigin="anonymous"></script>
@endpush