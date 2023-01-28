<div class="zone-carousel">
    @foreach ($zones as $zone)
    <div class="card carousel-cell zone-carousel-item bg-white">
        <div class="card-body bg-secondary py-5">
            <h3 class="text-center font-weight-bold"><a href="{{ route($route_prefix.'.zones.units.index', [ 'zone_id' => $zone->id] ) }}" class="text-white">{{ $zone->name }}</a></h3>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                No. Units
                <a href="{{ route($route_prefix.'.zones.units.index', [ 'zone_id' => $zone->id] ) }}" class="float-right badge badge-pill badge-primary font-weight-semi-bold">{{ $zone->units_count ?? 'N/A' }}</a>
            </li> 
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Construction Progress
                <a href="javascript::void(0)" class="float-right badge badge-pill badge-primary font-weight-semi-bold">{{ $zone->progress_average ? (number_format($zone->progress_average,2) * 100). " %"  : '0 %' }} </a>
            </li> 
            <li class="list-group-item d-flex justify-content-between align-items-center">
                No. Site Engineers
                <a href="{{ route($route_prefix.'.zones.site_engineers.index', ['zone_id' => $zone->id]) }}" class="float-right badge badge-pill badge-primary font-weight-semi-bold">{{ $zone->managed_users_count ?? 'N/A' }}</a>
            </li> 
        </ul>
    </div>  
    @endforeach
</div>

@push("scripts")
<script type="text/javascript">  
$('.zone-carousel').flickity({
    cellAlign: 'left',
    contain: true,
    pageDots: false
});
</script>
@endpush
