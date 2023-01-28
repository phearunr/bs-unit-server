<div class="unit-type-carousel">
    @foreach ($project->unitTypes as $unit_type)
    <div class="card carousel-cell unit-type-carousel-item">
        <a href="{{ route($route_prefix.'.unit_types.show', ['unit_type' => $unit_type->id]) }}">
            <img class="card-img-top" src="{{ $unit_type->feature_image_url }}" alt="{{ $unit_type->name }}">
        </a>
        <div class="card-body">
        <h5 class="card-title mb-0"><a href="{{ route($route_prefix.'.unit_types.show', ['unit_type' => $unit_type->id]) }}">{{ $unit_type->name }}</a></h5>
            <p class="mb-0">
                <a href="{{ route($route_prefix.'.projects.units.index', ['project_id' => $project->id, 'unit_type_id' => $unit_type->id]) }}" class="badge badge-pill badge-primary">Units: {{ $unit_type->units_count ?? 'N/A' }}</a>
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

@push("scripts")
<script type="text/javascript">  
$('.unit-type-carousel').flickity({
    cellAlign: 'left',
    contain: true,
    pageDots: false
});
</script>
@endpush
