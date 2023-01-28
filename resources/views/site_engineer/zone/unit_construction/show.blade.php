@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.css" integrity="sha512-Woz+DqWYJ51bpVk5Fv0yES/edIMXjj3Ynda+KWTIkGoynAMHrqTcDUQltbipuiaD5ymEo9520lyoVOo9jCQOCA==" crossorigin="anonymous" />
@endsection

@section('content')
<div class="container"> 
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card mb-3"> 
                @if($unit->unitType->media->count() > 0)
                <div id="unitTypeGalleryCarousell" class="carousel border slide" data-ride="carousel" tabindex="-1" aria-hidden="true">
                    <div class="carousel-inner">
                @foreach($unit->unitType->media->reverse() as $media)
                        <div class="carousel-item {{ ($loop->index == 0) ? 'active' : '' }}">
                            <a href="{{ $media->getFullUrl() }}" data-lightbox="roadtrip" class="card-img-top img-responsive">
                                <img class="card-img-top img-responsive" src="{{ $media->getFullUrl('thumb')}}" alt="Card image cap">
                            </a>
                        </div>
                @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#unitTypeGalleryCarousell" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#unitTypeGalleryCarousell" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                @else
                <a href="{{$unit->unitType->feature_image_url}}" data-lightbox="image-1" >
                    <img class="card-img-top img-responsive" src="{{$unit->unitType->feature_image_url}}" alt="Card image cap">
                </a>
                @endif 
                <div class="card-body bg-light position-relative">
                    <div class="d-flex flex-column">
                        <div class="">
                            <h5 class="mb-0 flex-fill"><strong>{{ $unit->code }}</strong></h5>
                            <span class="{{ $unit->action->getActionCss() }}">{{ $unit->action->action }}</span>
                            <span class="{{ $unit->action->getStatusActionCss() }}">{{ $unit->action->status_action }}</span>
                        </div>          
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <small class="text-muted d-block">Unit Type</small>
                        <span class="d-block font-weight-bold">{{ $unit->unitType->name }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">Zone</small>
                        <span class="d-block font-weight-bold">{{ ($unit->zone) ? $unit->zone->name : 'Unassigned Zone' }}</span>
                    </li>                    
                    <li class="list-group-item">
                        <small class="text-muted d-block">Project</small>
                        <span class="d-block font-weight-bold">{{ $unit->unitType->project->name_en }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">Company</small>
                        <span class="d-block font-weight-bold">{{ $unit->unitType->project->company->name_en }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">Measurement</small> 
                        <span class="d-block font-weight-bold">Land Size: {{ ( ($unit->land_size_width AND $unit->land_size_length)  ? $unit->land_size_width.'m x '.$unit->land_size_length.'m' : $unit->land_area. ' Sqm' )}}</span>

                        <span class="d-block font-weight-bold">Building Size: {{ ( ($unit->building_size_width AND $unit->building_size_length) ? $unit->building_size_width.'m x '.$unit->building_size_length.'m' : $unit->building_area. ' Sqm' )}}</span>
                    </li>  
                    <li class="list-group-item"><small class="text-muted d-block">Facilities</small> 
                        <table class="table table-borderless table-sm mb-0">
                            <tbody>
                                <tr class="font-weight-bold">
                                    <td>Bedroom:</td>
                                    <td>{{ ( $unit->bedroom ? $unit->bedroom : 'n/a' ) }}</td>
                                </tr>
                                <tr class="font-weight-bold">
                                    <td>Bathroom:</td>
                                    <td>{{ ( $unit->bathroom ? $unit->bathroom : 'n/a' ) }}</td>
                                </tr>
                                <tr class="font-weight-bold">
                                    <td>Living Room:</td>
                                    <td>{{ ( $unit->living_room ? $unit->living_room : 'n/a' ) }}</td>
                                </tr>
                                <tr class="font-weight-bold">
                                    <td>Kitchen:</td>
                                    <td>{{ ( $unit->kitchen ? $unit->kitchen : 'n/a' ) }}</td>
                                </tr>
                               
                                <tr class="font-weight-bold">
                                    <td>Swimming Pool:</td>
                                    <td>{{ ( $unit->swimming_pool ? $unit->swimming_pool : 'n/a' ) }}</td>
                                </tr>
                            </tbody>
                        </table>             
                    </li>  
                </ul>    
            </div>
        </div>
        <div class="col-lg-8">
            <ul class="yk-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript::void(0)">Construction Progress</a>
                </li>               
            </ul>
            <div class="row">
                <div class="col">
                    <div class="p-4 bg-white">
                        <unit-construction-procedure unit-id="{{ $unit->id }}" :show-summary="true" :editable="{{ (Auth::user()->can('update-unit-construction')) ? 'true' : 'false' }}"></unit-construction-procedure>
                    </div>
                    <div class="px-4 pb-2 bg-white">
                        <h4>Comments:</h4>
                        <unit-comment-list unit-id="{{ $unit->id }}" editable="true"></unit-comment-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push("scripts")
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js" integrity="sha512-k2GFCTbp9rQU412BStrcD/rlwv1PYec9SNrkbQlo6RZCf75l6KcC3UwDY8H5n5hl4v77IDtIPwOk9Dqjs/mMBQ==" crossorigin="anonymous"></script>

<script type="text/javascript">
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
</script>
@endpush