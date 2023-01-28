@extends('layouts.app')

@section('styles')
<style>
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.css" integrity="sha512-Woz+DqWYJ51bpVk5Fv0yES/edIMXjj3Ynda+KWTIkGoynAMHrqTcDUQltbipuiaD5ymEo9520lyoVOo9jCQOCA==" crossorigin="anonymous" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-3">
            @if($unit_type->media->count() > 0)
                <div id="unitTypeGalleryCarousell" class="carousel border slide" data-ride="carousel" tabindex="-1" aria-hidden="true">
                    <div class="carousel-inner">
                @foreach($unit_type->media->reverse() as $media)
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
                <a href="{{$unit_type->feature_image_url}}" data-lightbox="image-1" >
                    <img class="card-img-top img-responsive" src="{{$unit_type->feature_image_url}}" alt="Card image cap">
                </a>
            @endif 
                <div class="card-body bg-light position-relative">
                    <h5 class="font-weight-bold">{{ $unit_type->name }}</h5>
                    <h6 class="card-subtitle mb-0 text-muted">{{ $unit_type->project->name_en }}</h6>
                    <div class="btn-group btn-group-action-absolute">
                        <a href="#" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="true" class="text-primary"><i class="fas fa-lg fa-ellipsis-v"></i></a> 
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('admin.contract_templates.preview', [ 'template_path' => $unit_type->contractTemplate->name, 'unit_type_id' => $unit_type->id, 'version'=>'v2']) }}" class="dropdown-item" target="_blank">{{ __("View Contract Template") }}</a>
                            @can('update-unit-type')
                            <a href="{{ route('admin.unit_types.edit', ['id'=>$unit_type->id]) }}" class="dropdown-item">{{ __("Edit") }}</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <small class="text-muted d-block">{{ __('Short Code') }}</small>    
                        <span class="d-block font-weight-bold">{{$unit_type->short_code}}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">{{ __('Type') }}</small>    
                        <span class="d-block font-weight-bold">{{ ucfirst($unit_type->contractTemplate->name) }}</span>
                    </li>                
                    <li class="list-group-item">
                        <small class="text-muted d-block">{{ __('Contract Transfer Fee') }}</small>
                        <span class="d-block font-weight-bold">${{ number_format($unit_type->contract_transfer_fee, 2) }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">{{ __('Annual Management Fee') }}</small>
                        <span class="d-block font-weight-bold">${{ number_format($unit_type->annual_management_fee, 2) }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">{{ __('Mgt. Fee per Squar Meter (Condo Only)') }}</small>
                        <span class="d-block font-weight-bold">${{ number_format($unit_type->management_fee_per_sqaure, 2) }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">{{ __('Deadline Duration (Month)') }}</small>    
                        <span class="d-block font-weight-bold">{{ $unit_type->deadline }}</span>
                    </li>
                     <li class="list-group-item">
                        <small class="text-muted d-block">{{ __('Extendable Deadline Duration (Month)') }}</small>    
                        <span class="d-block font-weight-bold">{{ $unit_type->extended_deadline }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-12 mb-2">
                    <div class="d-flex flex-column bg-white border">
                        <div class="text-center bg-primary p-3 ">
                            <a href="{{ route('project_coordinator.projects.units.index', [ 'id' => $unit_type->project_id, 'unit_type_id' => $unit_type->id]) }}" class="font-weight-bold display-4 d-block text-white">{{ $unit_type->units_count ?? 'N/A' }}</a>
                            <small class="text-white">{{ __('Total Units') }}</small>
                        </div>
                        <div class="d-flex flex-column flex-sm-row">
                            <div class="flex-fill p-3 text-center border bg-grey">
                                <h4 class="mb-0 font-weight-bold"><a href="{{ route('project_coordinator.projects.units.index', [ 'id' => $unit_type->project_id, 'unit_type_id' => $unit_type->id, 'status' => 'AVAILABLE']) }}">{{ $unit_type->available_unit_count ?? 'N/A' }}</a></h4>
                                <small class="text-muted">{{ __('Available') }}</small>
                            </div>
                            <div class="flex-fill p-3 text-center border bg-grey">
                                <h4 class="mb-0 font-weight-bold"><a href="{{ route('project_coordinator.projects.units.index', [ 'id' => $unit_type->project_id, 'unit_type_id' => $unit_type->id, 'status' => 'UNAVAILABLE']) }}">{{ $unit_type->unavailable_unit_count ?? 'N/A' }}</a></h4>
                                <small class="text-muted">{{ __('Unavailable') }}</small>
                            </div>
                            <div class="flex-fill p-3 text-center border bg-grey">
                                <h4 class="mb-0 font-weight-bold"><a href="{{ route('project_coordinator.projects.units.index', [ 'id' => $unit_type->project_id, 'unit_type_id' => $unit_type->id, 'status' => 'HOLD']) }}">{{ $unit_type->hold_unit_count ?? 'N/A' }}</a></h4>
                                <small class="text-muted">{{ __('Hold') }}</small>
                            </div>
                            <div class="flex-fill p-3 text-center border bg-grey">
                                <h4 class="mb-0 font-weight-bold"><a href="{{ route('project_coordinator.projects.units.index', [ 'id' => $unit_type->project_id, 'unit_type_id' => $unit_type->id, 'status' => 'DEPOSIT']) }}">{{ $unit_type->deposit_unit_count ?? 'N/A' }}</a></h4>
                                <small class="text-muted">{{ __('Deposit') }}</small>
                            </div>
                            <div class="flex-fill p-3 text-center border bg-grey">
                                <h4 class="mb-0 font-weight-bold"><a href="{{ route('project_coordinator.projects.units.index', [ 'id' => $unit_type->project_id, 'unit_type_id' => $unit_type->id, 'status' => 'CONTRACT']) }}">{{ $unit_type->contract_unit_count ?? 'N/A' }}</a></h4>
                                <small class="text-muted">{{ __('Contract') }}</small>
                            </div>
                        </div>
                    </div>      
                </div> 
            </div> 

            <section id="payment_option">
                <h5 class="font-weight-bold mt-2">{{ __('Payment Options') }}</h5>
                <div class="bg-white border" style="max-height: 400px; overflow-y: auto;">
                @foreach($payment_options as $payment_option)
                <div class="d-flex flex-column p-3 border-bottom">
                    <span class="d-block font-weight-bold">{{ $payment_option->name}}</span>
                    <div class="row">
                        <div class="col-8">Initial Deposit: </div>
                        <div class="col-4"><span class="font-weight-bold">$ {{ number_format($payment_option->deposit_amount,2) }}</span></div>

                        <div class="col-8">Special Discount (%): </div>
                        <div class="col-4"><span class="font-weight-bold">{{ $payment_option->special_discount }} %</span></div>

                        <div class="col-8">Loan Duration (Month): </div>
                        <div class="col-4"><span class="font-weight-bold">{{ $payment_option->loan_duration }}</span></div>

                        <div class="col-8">Annual Interest Rate: </div>
                        <div class="col-4"><span class="font-weight-bold">{{ $payment_option->interest }}</span></div>

                        <div class="col-8">Down Payment: </div>
                        <div class="col-4"><span class="font-weight-bold">{{ $payment_option->is_first_payemnt ? "Yes" : "No" }}</span></div>

                        <div class="col-8">Down Payment Duration (Month) </div>
                        <div class="col-4"><span class="font-weight-bold">{{ $payment_option->first_payment_duration }}</span></div>

                        <div class="col-8">Down Payment Percentage: </div>
                        <div class="col-4"><span class="font-weight-bold">{{ $payment_option->first_payment_percentage }} %</span></div>
                    </div>
                </div> 
                @endforeach
                </div>
            </section>
            @include('utils.more_functionality') 
            
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
