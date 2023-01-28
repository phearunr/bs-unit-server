@extends('layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/flickity.min.css') }}">
@endsection

@section('content')
<div class="container">
    @foreach($projects as $project) 
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex">
                <h5 class="w-100 text-truncate">
                    {{ $project->name_en }} 
                </h5>
                <a href="{{ route('sale.projects.master_plan.view', ['id'=> $project->id]) }}" class="text-nowrap">View Plan</a>
            </div>
            @if( $project->unitTypes->count() > 0)
            <div class="main-carousel mb-3">
                @foreach ($project->unitTypes as $unit_type)
                <div class="card carousel-cell unit-type-carousel-item">
                    <a href="{{ route('sale.unit_types.show', ['unit_type' => $unit_type->id]) }}">
                        <img class="card-img-top" src="{{ $unit_type->feature_image_url }}" alt="{{ $unit_type->name }}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title mb-0">
                            <a href="{{ route('sale.unit_types.show', ['unit_type' => $unit_type->id]) }}">{{ $unit_type->name }}</a>
                        </h5>
                        <p class="mb-0">                            
                            @if( count($unit_type->activeDiscountPromotions) > 0 )
                            <span class="badge badge-pill badge-danger">Dis. $ {{ number_format($unit_type->activeDiscountPromotions[0]->amount, 0) }}</span>
                            <span class="badge badge-pill badge-secondary"><i class="far fa-calendar-alt"></i> {{ $unit_type->activeDiscountPromotions[0]->start_date->toSystemDateString() }} {{ __('until') }} {{ $unit_type->activeDiscountPromotions[0]->end_date->toSystemDateString() }}</span>
                            @else
                            <span class="badge badge-pill badge-danger">{{ __('No Discount') }}</span>
                            @endif
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="card">
                <div class="card-body d-flex justify-content-center" style="height: 250px;">
                    <h5 class="align-self-center ">{{ __("No Unit type available for this project") }}</h5>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endforeach
    {{ $projects->appends(request()->except(['page','_token'])) }}
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
