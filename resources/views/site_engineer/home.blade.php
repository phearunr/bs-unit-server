@extends('layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/flickity.min.css') }}">
<style type="text/css">
    .unit-type-carousel-item, .zone-carousel-item {
        width: 300px;
        margin: 0 10px;
    }

    .unit-type-carousel-item:first-child, .zone-carousel-item:first-child {
        margin-left: 0px;       
    }

    .unit-type-carousel-item .card-img-top {
        width: 100%;
        height: 178px;
        object-fit: cover;
    }

    .btn-group-action-absolute {
        position: absolute;     
        top: 1rem;
        right: 1rem;
    }

    @media (max-width: 768px) { 
        .unit-type-carousel-item {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
        @foreach($projects as $project)
            <h5 class="mt-3 ">{{ $project->name_en }}</h5>        
            <div class="main-carousel mt-3 ">
            @foreach($project->zones as $zone)
                <div class="card carousel-cell zone-carousel-item bg-white">
                    <div class="card-body bg-secondary py-5">
                        <h3 class="text-center font-weight-bold"><a href="{{ route('site_engineer.zones.units.index', ['id' => $zone->id]) }}" class="text-white">{{ $zone->name }}</a></h3>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            No. Units
                            <a href="javascript::void(0)" class="float-right badge badge-pill badge-primary font-weight-semi-bold">{{ $zone->units_count }} </a>
                        </li> 
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            Construction Progress
                            <a href="javascript::void(0)" class="float-right badge badge-pill badge-primary font-weight-semi-bold">{{ $zone->progress_average ? (number_format($zone->progress_average,2) * 100). " %"  : '0 %' }} </a>
                        </li> 
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            No. Site Engineers
                            <a href="{{ route('site_engineer.zones.site_engineers.index', ['zone_id' => $zone->id]) }}" class="float-right badge badge-pill badge-primary font-weight-semi-bold">{{ $zone->managed_users_count ?? 'N/A' }}</a>
                        </li> 
                    </ul>
                </div>  
            @endforeach
            </div> 
        @endforeach
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