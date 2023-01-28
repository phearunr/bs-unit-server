@if($unit_type->media->count() > 0)
<div id="unitTypeGalleryCarousell" class="carousel border slide" data-ride="carousel" tabindex="-1" aria-hidden="true">
    <div class="carousel-inner">
    @foreach($unit_type->media->reverse() as $media)
    <div class="carousel-item {{ ($loop->index == 0) ? 'active' : '' }}">
        <a href="{{ $media->getFullUrl() }}" data-lightbox="roadtrip" class="card-img-top img-responsive">
            <img class="card-img-top img-responsive" src="{{ $media->getFullUrl()}}" alt="Card image cap">
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